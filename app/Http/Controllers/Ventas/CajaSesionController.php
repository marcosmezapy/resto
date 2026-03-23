<?php

namespace App\Http\Controllers\Ventas;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

use App\Models\Caja;
use App\Models\CajaSesion;
use App\Models\Venta;
use App\Models\VentaPago;

use App\Models\MovimientoCaja;

class CajaSesionController extends Controller
{

    /*
    -----------------------------
    ABRIR CAJA (FORM)
    -----------------------------
    */

    public function create()
    {

        $cajaAbierta = CajaSesion::where('usuario_id',Auth::id())
            ->where('estado','abierta')
            ->where('sucursal_id', session('sucursal_id')) // 🔥
            ->first();

        if($cajaAbierta){
            return redirect()->route('ventas.cajas.dashboard');
        }

        $cajas = Caja::where('sucursal_id', session('sucursal_id'))->get(); // 🔥

        return view('ventas.cajas.abrir',compact('cajas'));

    }



    /*
    -----------------------------
    GUARDAR APERTURA
    -----------------------------
    */

    public function store(Request $request)
    {

        $caja = Caja::findOrFail($request->caja_id);

        // 🔥 VALIDACIÓN
        if($caja->sucursal_id != session('sucursal_id')){
            abort(403, 'Caja no pertenece a esta sucursal');
        }
        CajaSesion::create([

            'caja_id' => $request->caja_id,
            'usuario_id' => Auth::id(),
            'sucursal_id' => session('sucursal_id'), // 🔥 AGREGAR
            'monto_apertura' => $request->monto_apertura,
            'estado' => 'abierta',
            'fecha_apertura' => now()

        ]);

        return redirect()->route('ventas.cajas.dashboard');

    }



    /*
    -----------------------------
    DASHBOARD CAJA
    -----------------------------
    */
    public function dashboard()
{

    $sesion = CajaSesion::where('usuario_id',Auth::id())
    ->where('estado','abierta')
    ->where('sucursal_id', session('sucursal_id')) // 🔥
    ->first();

if(!$sesion){
return redirect()->route('ventas.cajas.abrir');
}

/*
-------------------------------------
VENTAS POR METODO
-------------------------------------
*/

$efectivo = VentaPago::whereHas('venta',function($q) use($sesion){
$q->where('caja_sesion_id',$sesion->id)
->where('estado','pagada');
})
->where('metodo_pago','efectivo')
->sum('monto');


$tarjeta = VentaPago::whereHas('venta',function($q) use($sesion){
$q->where('caja_sesion_id',$sesion->id)
->where('estado','pagada');
})
->where('metodo_pago','tarjeta')
->sum('monto');


$transferencia = VentaPago::whereHas('venta',function($q) use($sesion){
$q->where('caja_sesion_id',$sesion->id)
->where('estado','pagada');
})
->where('metodo_pago','transferencia')
->sum('monto');


/*
-------------------------------------
MOVIMIENTOS DE CAJA
-------------------------------------
*/

$ingresos = MovimientoCaja::where('caja_sesion_id',$sesion->id)
->where('tipo','ingreso')
->sum('monto');

$gastos = MovimientoCaja::where('caja_sesion_id',$sesion->id)
->where('tipo','gasto')
->sum('monto');

$retiros = MovimientoCaja::where('caja_sesion_id',$sesion->id)
->where('tipo','retiro')
->sum('monto');


$movimientos = MovimientoCaja::where('caja_sesion_id',$sesion->id)
->latest()
->get();


/*
-------------------------------------
VENTAS TOTALES (solo informativo)
-------------------------------------
*/

$totalVentas = $efectivo + $tarjeta + $transferencia;


/*
-------------------------------------
CAJA REAL
-------------------------------------
*/

$cajaEsperada = 
$sesion->monto_apertura
+ $efectivo
+ $ingresos
- $gastos
- $retiros;


/*
-------------------------------------
MESAS ABIERTAS
-------------------------------------
*/

$ventasAbiertas = Venta::where('caja_sesion_id',$sesion->id)
->where('estado','abierta')
->get();

$pendiente = $ventasAbiertas->sum('total');


return view('ventas.cajas.dashboard',compact(
'sesion',
'efectivo',
'tarjeta',
'transferencia',
'totalVentas',
'cajaEsperada',
'pendiente',
'ventasAbiertas',
'movimientos',
'ingresos',
'gastos',
'retiros'
));

}



public function movimiento()
{
    return view('ventas.cajas.movimiento');
}



    /*
    -----------------------------
    CERRAR CAJA
    -----------------------------
    */

public function cerrar()
{
    $caja = CajaSesion::where('usuario_id',Auth::id())
    ->where('estado','abierta')
    ->where('sucursal_id', session('sucursal_id'))
    ->first();

    if(!$caja){
        return redirect()->route('ventas.cajas.abrir');
    }

    /*
    -----------------------------------
    LIMPIAR VENTAS VACÍAS
    -----------------------------------
    */

    $ventasAbiertas = Venta::where('caja_sesion_id',$caja->id)
        ->where('estado','abierta')
        ->with('detalles') // 👈 IMPORTANTE
        ->get();

    foreach($ventasAbiertas as $venta){
        if($venta->detalles->count() == 0){
            $venta->update(['estado'=>'cancelada']);
        }
    }

    /*
    -----------------------------------
    VERIFICAR SI QUEDAN ABIERTAS REALES
    -----------------------------------
    */

    $ventasReales = Venta::where('caja_sesion_id',$caja->id)
        ->where('estado','abierta')
        ->count();

    if($ventasReales > 0){
        return redirect()
        ->route('ventas.cajas.dashboard')
        ->with('error','No puedes cerrar la caja porque hay ventas abiertas.');
    }

    /*
    -----------------------------------
    RESTO IGUAL
    -----------------------------------
    */

    $efectivo = VentaPago::whereHas('venta',function($q) use ($caja){
        $q->where('caja_sesion_id',$caja->id)
        ->where('estado','pagada');
    })->where('metodo_pago','efectivo')->sum('monto');

    $tarjeta = VentaPago::whereHas('venta',function($q) use ($caja){
        $q->where('caja_sesion_id',$caja->id)
        ->where('estado','pagada');
    })->where('metodo_pago','tarjeta')->sum('monto');

    $transferencia = VentaPago::whereHas('venta',function($q) use ($caja){
        $q->where('caja_sesion_id',$caja->id)
        ->where('estado','pagada');
    })->where('metodo_pago','transferencia')->sum('monto');

    $ingresos = MovimientoCaja::where('caja_sesion_id',$caja->id)
        ->where('tipo','ingreso')->sum('monto');

    $gastos = MovimientoCaja::where('caja_sesion_id',$caja->id)
        ->where('tipo','gasto')->sum('monto');

    $retiros = MovimientoCaja::where('caja_sesion_id',$caja->id)
        ->where('tipo','retiro')->sum('monto');

    $totalVentas = $efectivo + $tarjeta + $transferencia;

    $totalEsperado = 
        $caja->monto_apertura
        + $efectivo
        + $ingresos
        - $gastos
        - $retiros;

    $movimientos = MovimientoCaja::where('caja_sesion_id',$caja->id)
    ->latest()
    ->get();


    return view('ventas.cajas.cerrar',compact(
        'caja','efectivo','tarjeta','transferencia',
        'ingresos','gastos','retiros',
        'totalVentas','totalEsperado',
         'movimientos' // 👈 AGREGAR
    ));
}


    /*
    -----------------------------
    GUARDAR CIERRE
    -----------------------------
    */

    public function cerrarStore(Request $request)
    {

        $caja = CajaSesion::findOrFail($request->caja_id);

        /*
        -----------------------------
        SEGURIDAD EXTRA
        -----------------------------
        */

        $ventasAbiertas = Venta::where('caja_sesion_id',$caja->id)
            ->where('estado','abierta')
            ->count();

        if($ventasAbiertas > 0){

            return redirect()
                ->route('ventas.cajas.dashboard')
                ->with('error','No puedes cerrar la caja porque existen mesas abiertas.');

        }


        $caja->update([

            'monto_contado' => $request->monto_contado,
            'estado' => 'cerrada',
            'fecha_cierre' => now()

        ]);

        return redirect()->route('ventas.pos.index');

        
    }




  /*
---------------------------------
HISTORIAL DE CAJAS
---------------------------------
*/

public function historial()
{

    $cajas = CajaSesion::with(['caja','usuario'])
        ->orderBy('id','desc')
        ->get();

    return view('ventas.cajas.historial',compact('cajas'));

}


/*
---------------------------------
DETALLE DE CAJA
---------------------------------
*/

public function detalle($id)
{
    $caja = CajaSesion::with(['caja','usuario'])->findOrFail($id);

    $ventas = Venta::where('caja_sesion_id',$caja->id)
        ->with(['mesa','cliente','pagos'])
        ->orderBy('id','desc')
        ->get();

    /*
    ---------------------------------
    TOTALES POR METODO
    ---------------------------------
    */

    $efectivo = 0;
    $tarjeta = 0;
    $transferencia = 0;

    foreach($ventas as $venta){
        foreach($venta->pagos as $pago){

            if($pago->metodo_pago == 'efectivo'){
                $efectivo += $pago->monto;
            }

            if($pago->metodo_pago == 'tarjeta'){
                $tarjeta += $pago->monto;
            }

            if($pago->metodo_pago == 'transferencia'){
                $transferencia += $pago->monto;
            }

        }
    }

    /*
    ---------------------------------
    MOVIMIENTOS
    ---------------------------------
    */

    $ingresos = MovimientoCaja::where('caja_sesion_id',$caja->id)
        ->where('tipo','ingreso')->sum('monto');

    $gastos = MovimientoCaja::where('caja_sesion_id',$caja->id)
        ->where('tipo','gasto')->sum('monto');

    $retiros = MovimientoCaja::where('caja_sesion_id',$caja->id)
        ->where('tipo','retiro')->sum('monto');

    /*
    ---------------------------------
    ARQUEO
    ---------------------------------
    */

    $esperado = 
        $caja->monto_apertura
        + $efectivo
        + $ingresos
        - $gastos
        - $retiros;

    $movimientos = MovimientoCaja::where('caja_sesion_id',$caja->id)
        ->latest()
        ->get();

    return view(
        'ventas.cajas.historial-detalle',
        compact(
            'caja','ventas',
            'efectivo','tarjeta','transferencia',
            'ingresos','gastos','retiros',
            'esperado','movimientos'
        )
    );
} 




public function storeMovimiento(Request $request)
{

    $sesion = CajaSesion::where('usuario_id', Auth::id())
    ->where('estado','abierta')
    ->where('sucursal_id', session('sucursal_id')) // 🔥
    ->first();

    if(!$sesion){
        return back()->with('error','No hay caja abierta');
    }

    MovimientoCaja::create([
        'caja_sesion_id' => $sesion->id,
        'user_id' => Auth::id(),
        'tipo' => $request->tipo,
        'descripcion' => $request->descripcion,
        'monto' => $request->monto
    ]);

    return redirect()->route('ventas.cajas.dashboard');

}



}
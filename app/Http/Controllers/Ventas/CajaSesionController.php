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
use App\Services\Caja\CajaSesionService;

class CajaSesionController extends Controller
{

    /*
    -----------------------------
    ABRIR CAJA (FORM)
    -----------------------------
    */

    public function create()
    {
        $service = app(CajaSesionService::class);

        if(!$service->puedeAbrirCaja()){
            return redirect()->route('ventas.cajas.dashboard');
        }

        $cajas = Caja::where('sucursal_id', session('sucursal_id'))->get();

        return view('ventas.cajas.abrir', compact('cajas'));
    }



    /*
    -----------------------------
    GUARDAR APERTURA
    -----------------------------
    */

        public function store(Request $request)
        {
            $service = app(CajaSesionService::class);

            try {

                $service->abrir(
                    $request->caja_id,
                    $request->monto_apertura
                );

                return redirect()->route('ventas.cajas.dashboard');

            } catch (\Exception $e){

                return back()->with('error', $e->getMessage());
            }
        }


    /*
    -----------------------------
    DASHBOARD CAJA
    -----------------------------
    */
public function dashboard()
{
    $service = app(CajaSesionService::class);

    $sesion = $service->getSesionActiva();

    if(!$sesion){
        return redirect()->route('ventas.cajas.abrir');
    }

    $data = $service->getDashboardData($sesion);

    return view('ventas.cajas.dashboard', array_merge([
        'sesion' => $sesion
    ], $data));
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
        $service = app(CajaSesionService::class);

        $sesion = $service->getSesionActiva();

        if(!$sesion){
            return redirect()->route('ventas.cajas.abrir');
        }

        try {

            $data = $service->getCierreData($sesion);

            return view('ventas.cajas.cerrar', array_merge([
                'caja' => $sesion
            ], $data));

        } catch (\Exception $e){

            return redirect()
                ->route('ventas.cajas.dashboard')
                ->with('error', $e->getMessage());
        }
    }


    /*
    -----------------------------
    GUARDAR CIERRE
    -----------------------------
    */

    public function cerrarStore(Request $request)
    {
        $service = app(CajaSesionService::class);

        try {

            $service->cerrar(
                $request->caja_id,
                $request->monto_contado
            );

            return redirect()->route('ventas.pos.index');

        } catch (\Exception $e){

            return redirect()
                ->route('ventas.cajas.dashboard')
                ->with('error', $e->getMessage());
        }
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
        $service = app(CajaSesionService::class);

        $data = $service->getDetalleCaja($id);

        return view('ventas.cajas.historial-detalle', $data);
    }



    public function storeMovimiento(Request $request)
    {
        $service = app(CajaSesionService::class);

        try {

            $service->registrarMovimiento(
                $request->tipo,
                $request->descripcion,
                $request->monto
            );

            return redirect()->route('ventas.cajas.dashboard');

        } catch (\Exception $e){

            return back()->with('error', $e->getMessage());
        }
    }



}
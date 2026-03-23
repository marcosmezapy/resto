<?php

namespace App\Http\Controllers\Ventas;

use App\Http\Controllers\Controller;
use App\Models\Venta;
use App\Models\VentaDetalle;
use App\Models\VentaDetalleLote;
use App\Models\PrdStock;
use App\Models\PrdMovimientoStock;
use App\Models\VentaPago;

use Illuminate\Support\Facades\DB;

class VentaController extends Controller
{

public function index()
{

    $ventas = Venta::where('sucursal_id', session('sucursal_id')) // 🔥
        ->with(['mesa','cliente'])
        ->orderBy('id','desc')
        ->paginate(20);

    return view('ventas.historial.index',compact('ventas'));

}



public function show($id)
{

    $venta = Venta::with([
        'detalles.producto',
        'pagos',
        'mesa',
        'cliente'
    ])->findOrFail($id);

    return view('ventas.historial.show',compact('venta'));

}



public function anular($id)
{

    $venta = Venta::with('detalles')->findOrFail($id);

    if($venta->estado == 'cancelada'){
        return back()->with('error','La venta ya está cancelada.');
    }

    DB::transaction(function() use ($venta){

        $detalles = VentaDetalle::where('venta_id',$venta->id)->get();

        foreach($detalles as $detalle){

            $lotes = VentaDetalleLote::where('venta_detalle_id',$detalle->id)->get();

            foreach($lotes as $lote){

                $stock = PrdStock::find($lote->stock_id);

                if($stock){

                    $stock->cantidad += $lote->cantidad;
                    $stock->save();

                    PrdMovimientoStock::create([
                        'producto_id'=>$stock->producto_id,
                        'deposito_id'=>$stock->deposito_id,
                        'stock_id'=>$stock->id,
                        'tipo'=>'entrada',
                        'cantidad'=>$lote->cantidad,
                        'referencia'=>'cancelacion_venta',
                        'referencia_id'=>$venta->id
                    ]);

                }

            }

        }

        VentaPago::where('venta_id',$venta->id)->delete();

        $venta->update([
            'estado'=>'cancelada'
        ]);

    });

    return redirect()
        ->route('ventas.historial.show',$venta->id)
        ->with('success','Venta cancelada correctamente.');

}
    public function print($id)
    {
        $venta = Venta::with([
            'detalles.producto',
            'cliente',
            'usuario',
            'sucursal',
            'tenant',
            'timbrado'
        ])->findOrFail($id);

        return view('ventas.print', compact('venta'));
    }

}
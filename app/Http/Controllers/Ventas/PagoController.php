<?php

namespace App\Http\Controllers\Ventas;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

use App\Models\Venta;
use App\Models\VentaPago;

class PagoController extends Controller
{

    public function index(Venta $venta)
    {
        return view('ventas.pos.pagar',compact('venta'));
    }



    public function store(Request $request, $venta_id)
    {

        DB::transaction(function() use ($request,$venta_id){

            $venta = Venta::where('id', $venta_id)
            ->where('sucursal_id', session('sucursal_id')) // 🔥
            ->firstOrFail();

            /*
            REGISTRAR PAGOS
            */

            foreach($request->pagos as $pago){

                if(!empty($pago['monto']) && $pago['monto'] > 0){

                    VentaPago::create([

                        'venta_id' => $venta->id,
                        'metodo_pago' => strtolower($pago['metodo_pago']),
                        'monto' => $pago['monto']

                    ]);

                }

            }


            /*
            PROCESAR FIFO STOCK
            */

            $pos = new \App\Livewire\Ventas\PosVenta();

            $pos->venta = $venta;

            $pos->procesarStockVenta();


            /*
            MARCAR VENTA PAGADA
            */

            $venta->update([
                'estado' => 'pagada'
            ]);

        });

        return redirect()->route('ventas.pos.index');

    }

}
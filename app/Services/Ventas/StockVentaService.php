<?php


namespace App\Services\Ventas;

use App\Models\Venta;
use App\Models\VentaDetalle;
use App\Models\PrdStock;
use App\Models\PrdMovimientoStock;
use App\Models\VentaDetalleLote;

class StockVentaService
{
    public function procesar(Venta $venta): void
    {
        $detalles = VentaDetalle::where('venta_id',$venta->id)->get();

        foreach($detalles as $detalle){

            $stocks = PrdStock::where('producto_id',$detalle->producto_id)
                ->where('sucursal_id', session('sucursal_id'))
                ->where('cantidad','>',0)
                ->orderBy('fecha_ingreso','asc')
                ->get();

            $cantidadPendiente = $detalle->cantidad;
            $costoTotal = 0;

            foreach($stocks as $stock){

                if($cantidadPendiente <= 0) break;

                $usar = min($stock->cantidad,$cantidadPendiente);

                VentaDetalleLote::create([
                    'venta_detalle_id'=>$detalle->id,
                    'stock_id'=>$stock->id,
                    'cantidad'=>$usar,
                    'costo_unitario'=>$stock->costo_compra
                ]);

                $costoTotal += ($usar * $stock->costo_compra);

                $stock->cantidad -= $usar;
                $stock->save();

                PrdMovimientoStock::create([
                    'producto_id'=>$detalle->producto_id,
                    'stock_id'=>$stock->id,
                    'tipo'=>'salida',
                    'cantidad'=>$usar,
                    'referencia'=>'venta',
                    'deposito_id'=>$stock->deposito_id,
                    'referencia_id'=>$venta->id,
                    'costo_unitario'=>$stock->costo_compra
                ]);

                $cantidadPendiente -= $usar;
            }

            if($detalle->cantidad > 0){
                $detalle->costo_unitario = $costoTotal / $detalle->cantidad;
                $detalle->save();
            }
        }
    }
}
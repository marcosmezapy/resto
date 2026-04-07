<?php

namespace App\Services\Ventas\Historico;

use App\Models\Venta;
use App\Models\VentaDetalleLote;
use App\Models\PrdStock;
use App\Models\PrdMovimientoStock;

class VentaService
{
    public function anular($ventaId)
    {
        $venta = Venta::with('detalles')->findOrFail($ventaId);

        if($venta->estado == 'cancelada'){
            throw new \Exception("Ya anulada");
        }

        foreach($venta->detalles as $detalle){

            // 🔥 traer pivotes reales
            $lotes = VentaDetalleLote::where('venta_detalle_id', $detalle->id)->get();

            foreach($lotes as $lote){

                $stock = PrdStock::find($lote->stock_id);

                if(!$stock){
                    continue; // seguridad
                }

                // 🔥 devolver stock correctamente
                $stock->cantidad += $lote->cantidad;
                $stock->save();

                // 🔥 registrar movimiento (MUY IMPORTANTE)
                PrdMovimientoStock::create([
                    'tenant_id' => $stock->tenant_id,
                    'producto_id' => $stock->producto_id,
                    'deposito_id' => $stock->deposito_id,
                    'tipo' => 'entrada',
                    'cantidad' => $lote->cantidad,
                    'costo_unitario' => $lote->costo_unitario,
                    'lote' => $stock->lote,
                    'descripcion' => 'Anulación de venta ID '.$venta->id
                ]);
            }
        }

        // 🔥 estado correcto
        $venta->estado = 'cancelada';
        $venta->estado_pago = 'cancelado';
        $venta->saldo = 0;

        $venta->save();
    }

    public function getDeudasCliente($clienteId)
    {
        return Venta::where('cliente_id', $clienteId)
            ->where('estado', 'cerrada')
            ->whereIn('estado_pago', ['pendiente','parcial'])
            ->orderByDesc('created_at')
            ->paginate(10, ['*'], 'deudasPage');
    }

    public function getComprasCliente($clienteId)
    {
        return Venta::where('cliente_id', $clienteId)
            ->where('estado', '!=', 'cancelada')
            ->orderByDesc('created_at')
            ->paginate(10, ['*'], 'comprasPage');
    }



}
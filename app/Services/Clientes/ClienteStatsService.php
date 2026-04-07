<?php

namespace App\Services\Clientes;

use App\Models\Venta;
use App\Models\VentaDetalle;
use Carbon\Carbon;

class ClienteStatsService
{
    public function fullStats($clienteId)
    {
        $ventas = Venta::where('cliente_id',$clienteId)
            ->where('estado','cerrada')
            ->orderBy('created_at')
            ->get();

        $total = $ventas->sum('total');
        $cantidad = $ventas->count();

        $ticketPromedio = $cantidad ? $total / $cantidad : 0;

        $ultima = $ventas->last();

        // 🔥 FRECUENCIA
        $frecuencia = 0;

        if($ventas->count() > 1){
            $dias = [];

            for($i=1;$i<count($ventas);$i++){
                $dias[] = Carbon::parse($ventas[$i]->created_at)
                    ->diffInDays($ventas[$i-1]->created_at);
            }

            $frecuencia = count($dias) ? array_sum($dias)/count($dias) : 0;
        }

        // 🔥 PRODUCTO MÁS COMPRADO
        $productoTop = VentaDetalle::whereHas('venta', function($q) use($clienteId){
                $q->where('cliente_id',$clienteId);
            })
            ->selectRaw('producto_id, SUM(cantidad) as total')
            ->groupBy('producto_id')
            ->orderByDesc('total')
            ->first();

        return [
            'total'=>$total,
            'cantidad'=>$cantidad,
            'ticket'=>$ticketPromedio,
            'ultima'=>$ultima?->created_at,
            'frecuencia'=>$frecuencia,
            'producto_top'=>$productoTop
        ];
    }
}
<?php

namespace App\Services\Clientes;

use App\Models\Venta;

class ClienteCreditoService
{
    public function detalle($clienteId)
    {
        // 🔴 SOLO DEUDAS REALES (NO canceladas y NO pagadas)
        $pendientes = Venta::where('cliente_id',$clienteId)
            ->where('estado','!=','cancelada') // 🔥 CLAVE
            ->where('estado_pago','!=','pagado')
            ->orderByDesc('created_at')
            ->paginate(10, ['*'], 'pendientes_page');

        // 🔵 TODAS (incluye canceladas)
        $todas = Venta::where('cliente_id',$clienteId)
            ->orderByDesc('created_at')
            ->paginate(10, ['*'], 'todas_page');

        return [
            'total'=>$pendientes->getCollection()->sum('saldo'),
            'cantidad'=>$pendientes->total(),
            'vencidas'=>$pendientes->getCollection()
                ->where('fecha_vencimiento','<',now())
                ->count(),

            'pendientes'=>$pendientes,
            'todas'=>$todas
        ];
    }
}
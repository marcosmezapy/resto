<?php

namespace App\Services\Ventas;

use App\Models\Venta;

class CreditoService
{
    public function aplicarCredito(Venta $venta, $clienteId, int $dias): void
    {
        if(!$clienteId || $clienteId == 1){
            throw new \Exception("Debe seleccionar un cliente para crédito");
        }

        $venta->condicion_pago = 'credito';
        $venta->saldo = $venta->total;
        $venta->dias_credito = $dias;
        $venta->fecha_vencimiento = now()->addDays($dias);

        $venta->save();
    }
}
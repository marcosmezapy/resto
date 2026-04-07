<?php

namespace App\Services\Ventas\Historico;

use App\Models\Venta;
use App\Models\VentaPago;
use Illuminate\Support\Facades\Auth;

class VentaPagoService
{
    public function registrar($ventaId, $monto, $metodo, $ref = null)
    {
        $venta = Venta::findOrFail($ventaId);

        VentaPago::create([
            'venta_id' => $venta->id,
            'tenant_id' => Auth::user()->tenant_id ?? null,
            'user_id' => Auth::id(),
            'metodo_pago' => $metodo,
            'referencia' => $ref,
            'monto' => $monto
        ]);

        $venta->saldo -= $monto;

        if($venta->saldo <= 0){
            $venta->estado_pago = 'pagado';
            $venta->saldo = 0;
        }

        $venta->save();
    }
}
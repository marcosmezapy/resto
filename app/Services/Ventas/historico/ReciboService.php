<?php


namespace App\Services\Ventas\Historico;

use App\Models\VentaPago;

class ReciboService
{
    public function getData($pagoId)
    {
        return VentaPago::with([
            'venta.cliente',
            'venta.detalles.producto',
            'user'
        ])->findOrFail($pagoId);
    }
}
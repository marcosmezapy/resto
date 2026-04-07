<?php


namespace App\Services\Ventas;

use App\Models\Venta;
use App\Models\VentaDetalle;

class VentaService
{
    public function actualizarTotales(Venta $venta): void
    {
        $detalles = VentaDetalle::where('venta_id', $venta->id)->get();

        if($detalles->isEmpty()){
            $venta->update([
                'estado' => 'cancelada',
                'total' => 0
            ]);
            return;
        }

        $total = $detalles->sum('subtotal');
        $totalIva = $detalles->sum('iva_total');

        $venta->update([
            'total' => $total,
            'total_iva' => $totalIva,
            'total_gravada_10' => $detalles->where('iva_porcentaje',10)->sum('subtotal'),
            'total_gravada_5' => $detalles->where('iva_porcentaje',5)->sum('subtotal'),
            'total_exenta' => $detalles->where('iva_porcentaje',0)->sum('subtotal'),
        ]);
    }

    public function cerrarVenta(Venta $venta): void
    {
        $venta->estado = 'cerrada';
        $venta->save();
    }
}
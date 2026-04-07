<?php


namespace App\Services\Ventas;

use App\Models\Venta;
use App\Models\VentaPago;

class PagoService
{
    public function registrarPagos(Venta $venta, array $pagos): void
    {
        $totalCubierto = 0;

        foreach($pagos as $pago){

            if(isset($pago['bloqueado']) && $pago['bloqueado']){
                continue;
            }

            $monto = floatval($pago['monto'] ?? 0);

            if($monto <= 0) continue;

            $montoAplicado = min($monto, $venta->total - $totalCubierto);

            if($montoAplicado <= 0) break;

            VentaPago::create([
                'venta_id' => $venta->id,
                'metodo_pago' => $pago['metodo_pago'],
                'monto' => $montoAplicado
            ]);

            $totalCubierto += $montoAplicado;
        }
    }

    public function totalPagado(Venta $venta): float
    {
        return VentaPago::where('venta_id', $venta->id)->sum('monto');
    }

    public function actualizarEstadoPago(Venta $venta): void
    {
        if($venta->condicion_pago === 'credito'){
            $venta->estado_pago = 'pendiente';
            $venta->save();
            return;
        }

        $totalPagado = $this->totalPagado($venta);

        if($totalPagado <= 0){
            $venta->estado_pago = 'pendiente';
        } elseif($totalPagado < $venta->total){
            $venta->estado_pago = 'parcial';
        } else {
            $venta->estado_pago = 'pagado';
        }

        $venta->save();
    }
}
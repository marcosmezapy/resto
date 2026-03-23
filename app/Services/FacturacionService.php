<?php

namespace App\Services;

use App\Models\Numeracion;
use App\Models\Timbrado;
use Illuminate\Support\Facades\DB;

class FacturacionService
{
    public function generarNumeroFactura($venta)
    {
        return DB::transaction(function () use ($venta) {

            // 1. TIMBRADO VIGENTE
            $timbrado = Timbrado::where('tenant_id', tenant_id())
                ->where('sucursal_id', sucursal_id())
                ->where('activo', 1)
                ->whereDate('fecha_inicio', '<=', now())
                ->whereDate('fecha_fin', '>=', now())
                ->firstOrFail();

            $puntoId = $timbrado->punto_expedicion_id;

            // 2. NUMERACION (LOCK)
            $numeracion = Numeracion::where('tenant_id', tenant_id())
                ->where('sucursal_id', sucursal_id())
                ->where('punto_expedicion_id', $puntoId)
                ->lockForUpdate()
                ->first();

            if (!$numeracion) {
                $numeracion = Numeracion::create([
                    'tenant_id' => tenant_id(),
                    'sucursal_id' => sucursal_id(),
                    'punto_expedicion_id' => $puntoId,
                    'ultimo_numero' => 0
                ]);
            }

            // 3. GENERAR NUMERO
            $numero = $numeracion->ultimo_numero + 1;

            $numeracion->update([
                'ultimo_numero' => $numero
            ]);

            // 4. FORMATEAR
            $numeroFormateado = str_pad($numero, 7, '0', STR_PAD_LEFT);

            $factura = sprintf(
                '%s-%s-%s',
                $timbrado->sucursal_codigo ?? '001',
                $timbrado->punto_codigo ?? '001',
                $numeroFormateado
            );

            // 5. GUARDAR EN VENTA
            $venta->update([
                'timbrado_id' => $timbrado->id,
                'punto_expedicion_id' => $puntoId,
                'numero' => $numero,
                'numero_factura' => $factura,
                'estado' => 'facturado'
            ]);

            return $venta;
        });
    }
}
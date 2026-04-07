<?php


namespace App\Services\Ventas;

use App\Models\Venta;

class FacturacionService
{
    public function generar(Venta $venta, $tipoDocumento, $caja): void
    {
        if($tipoDocumento === 'factura'){
            $this->generarFactura($venta, $caja);
        } else {
            $this->generarTicket($venta);
        }
    }

    private function generarFactura(Venta $venta, $caja): void
    {
        $numeracion = \App\Models\Numeracion::where('tenant_id',$venta->tenant_id)
            ->where('sucursal_id',$venta->sucursal_id)
            ->where('punto_expedicion_id',$caja->punto_expedicion_id)
            ->lockForUpdate()
            ->firstOrFail();

        $nuevoNumero = $numeracion->ultimo_numero + 1;

        $timbrado = \App\Models\Timbrado::where('tenant_id',$venta->tenant_id)
            ->where('estado','vigente')
            ->firstOrFail();

        if($nuevoNumero > $timbrado->numero_fin){
            throw new \Exception("Timbrado agotado");
        }

        $numeroDocumento = str_pad($nuevoNumero, 7, '0', STR_PAD_LEFT);

        $numeracion->update(['ultimo_numero'=>$nuevoNumero]);
        $timbrado->update(['ultimo_numero_usado'=>$nuevoNumero]);

        $venta->update([
            'tipo_documento'=>'factura',
            'numero_documento'=>$numeroDocumento,
            'timbrado_id'=>$timbrado->id,
            'punto_expedicion_id'=>$caja->punto_expedicion_id
        ]);
    }

    private function generarTicket(Venta $venta): void
    {
        $nuevoNumero = Venta::where('tenant_id',$venta->tenant_id)
            ->where('tipo_documento','ticket')
            ->max('numero') + 1;

        $venta->update([
            'tipo_documento'=>'ticket',
            'numero'=>$nuevoNumero,
            'numero_documento'=>str_pad($nuevoNumero,6,'0',STR_PAD_LEFT)
        ]);
    }
}
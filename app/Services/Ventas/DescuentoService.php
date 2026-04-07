<?php


namespace App\Services\Ventas;

class DescuentoService
{
    public function aplicarPorcentaje($precioOriginal, $cantidad, $descuento, $ivaPorcentaje)
    {
        $precioFinal = $precioOriginal * (1 - ($descuento / 100));

        $subtotalOriginal = $precioOriginal * $cantidad;
        $subtotalFinal = $precioFinal * $cantidad;

        // IVA ORIGINAL
        if($ivaPorcentaje == 10){
            $ivaOriginalUnit = $precioOriginal / 11;
            $ivaFinalUnit = $precioFinal / 11;
        }elseif($ivaPorcentaje == 5){
            $ivaOriginalUnit = $precioOriginal / 21;
            $ivaFinalUnit = $precioFinal / 21;
        }else{
            $ivaOriginalUnit = 0;
            $ivaFinalUnit = 0;
        }

        return [
            'precio_final' => $precioFinal,
            'subtotal' => $subtotalFinal,
            'subtotal_original' => $subtotalOriginal,

            'iva_unitario' => $ivaFinalUnit,
            'iva_total' => $ivaFinalUnit * $cantidad,

            'iva_original' => $ivaOriginalUnit * $cantidad
        ];
    }
}
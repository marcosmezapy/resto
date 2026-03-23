<?php

namespace App\Services;

use App\Models\PrdStock;
use App\Models\PrdMovimientoStock;

class StockService
{

    public static function descontarProducto($producto_id,$cantidad,$venta_id)
    {

        $lotes = PrdStock::where('producto_id',$producto_id)
        ->where('sucursal_id', session('sucursal_id'))
        ->where('cantidad','>',0)
        ->orderBy('created_at','asc')
        ->get();

        $cantidad_restante = $cantidad;

        foreach($lotes as $lote){

            if($cantidad_restante <= 0){
                break;
            }

            if($lote->cantidad >= $cantidad_restante){
                $descuento = $cantidad_restante;
            }else{
                $descuento = $lote->cantidad;
            }

            $lote->cantidad -= $descuento;

            $lote->save();

            PrdMovimientoStock::create([

            'producto_id'   => $producto_id,
            'deposito_id'   => $lote->deposito_id,
            'lote_id'       => $lote->id,
            'cantidad'      => -$descuento,
            'tipo'          => 'salida',
            'referencia_id' => $venta_id

            ]);

            $cantidad_restante -= $descuento;
        }

        if($cantidad_restante > 0){

        throw new \Exception("Stock insuficiente");

        }

    }

    public static function ingresarStock(
    $producto_id,
    $cantidad,
    $sucursal_id,
    $tenant_id,
    $motivo = 'compra',
    $costo_compra, // 🔥 NUEVO
    $deposito_id, // 🔥 NUEVO
    $referencia_id = null,
    $fecha_ingreso = null,
) {

    // 👉 Crear nuevo lote de stock
    $stock = PrdStock::create([
        'producto_id' => $producto_id,
        'sucursal_id' => $sucursal_id,
        'cantidad' => $cantidad,
        'costo_compra'  => $costo_compra, // 🔥 FIX
        'deposito_id' => $deposito_id, // 🔥 FIX
        'tenant_id' => $tenant_id,
        'fecha_ingreso' => $fecha_ingreso ?? now(), // 🔥 CLAVE
    ]);

    // 👉 Registrar movimiento
    PrdMovimientoStock::create([
        'producto_id'   => $producto_id,
        'deposito_id'   => $stock->deposito_id ?? null,
        'lote_id'       => $stock->id,
        'cantidad'      => $cantidad,
        'tipo'          => 'entrada',
        'referencia_id' => $referencia_id,
        'motivo'        => $motivo
    ]);
}

}
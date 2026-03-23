<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Models\Traits\BelongsToTenant;

class VentaDetalle extends Model
{
    use BelongsToTenant;
    protected $table = 'venta_detalles';

    protected $fillable = [

        'venta_id',
        'producto_id',
        'precio',
        'cantidad',
        'subtotal',
        'iva_porcentaje',
        'iva_unitario',
        'iva_total',
        'costo_unitario'
    ];

    public function venta()
    {
        return $this->belongsTo(Venta::class);
    }


    public function producto()
{
    return $this->belongsTo(\App\Models\PrdProducto::class,'producto_id');
}


public function lote()
{
    return $this->belongsTo(PrdStock::class,'lote_id');
}

public function lotes()
{
return $this->hasMany(VentaDetalleLote::class,'venta_detalle_id');
}

}
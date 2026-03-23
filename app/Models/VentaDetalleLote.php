<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Models\Traits\BelongsToTenant;

class VentaDetalleLote extends Model
{
    use BelongsToTenant;
protected $table = 'venta_detalle_lotes';

protected $fillable = [
'venta_detalle_id',
'stock_id',
'cantidad',
'costo_unitario'
];

/* RELACIONES */

public function detalle()
{
return $this->belongsTo(VentaDetalle::class,'venta_detalle_id');
}

public function stock()
{
return $this->belongsTo(PrdStock::class,'stock_id');
}

}
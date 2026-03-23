<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Models\PrdStock;
use App\Models\Traits\BelongsToTenant;

class PrdProducto extends Model
{
    use BelongsToTenant;
    
    protected $table = 'prd_productos';

    protected $fillable = [
        'nombre',
        'descripcion',
        'sku',
        'es_stockeable',
        'clasificacion_id',
        'iva_tipo_id',
        'costo_base',
        'precio_venta'
    ];
        protected $casts = [
        'es_stockeable' => 'boolean',
    ];

    public function stocks()
    {
        return $this->hasMany(PrdStock::class, 'producto_id');
    }
    public function clasificacion()
{
    return $this->belongsTo(PrdClasificacion::class, 'clasificacion_id');
}

    public function movimientos()
    {
        return $this->hasMany(PrdMovimientoStock::class,'producto_id');
    }

    public function ivaTipo()
    {
        return $this->belongsTo(ivaTipo::class, 'iva_tipo_id');
    }

}
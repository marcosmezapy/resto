<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Models\Traits\BelongsToTenant;

class PuntoExpedicion extends Model
{
    use BelongsToTenant;
    protected $table = 'puntos_expediciones';

    protected $fillable = ['tenant_id','sucursal_id','codigo','descripcion','activo'];

    public function sucursal()
    {
        return $this->belongsTo(Sucursal::class);
    }
    public function timbrados()
    {
        return $this->hasMany(\App\Models\Timbrado::class, 'punto_expedicion_id');
    }
}
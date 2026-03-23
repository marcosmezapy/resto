<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Sucursal extends Model
{
    protected $table = 'sucursales';
    protected $fillable = ['tenant_id','codigo','nombre','direccion','telefono','email','activo'];

    public function puntosExpedicion()
    {
        return $this->hasMany(PuntoExpedicion::class);
    }

    public function timbrados()
    {
        return $this->hasMany(Timbrado::class);
    }
}

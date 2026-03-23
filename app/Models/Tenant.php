<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Tenant extends Model
{
    protected $fillable = [
        'nombre',
        'estado',
        'fecha_vencimiento',
        'razon_social',
        'ruc',
        'direccion',
        'telefono',
        'email',
        'logo',
        'mensaje_ticket'
    ];
}
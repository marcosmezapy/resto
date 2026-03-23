<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Numeracion extends Model
{
    protected $table = 'numeraciones';

    protected $fillable = [
        'tenant_id',
        'sucursal_id',
        'punto_expedicion_id',
        'ultimo_numero'
    ];
}
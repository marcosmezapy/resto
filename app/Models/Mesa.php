<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Models\Traits\BelongsToTenant;

class Mesa extends Model
{
    use BelongsToTenant;
    protected $table = 'mesas';

    protected $fillable = [
        'numero',
        'capacidad',
        'activa',
        'tenant_id',
        'sucursal_id',
        'ocupada'
    ];

}
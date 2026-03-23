<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Models\Traits\BelongsToTenant;

class VentaPago extends Model
{
    use BelongsToTenant;
    protected $table = 'venta_pagos';

    protected $fillable = [

        'venta_id',
        'metodo_pago',
        'monto'

    ];

    public function venta()
    {
        return $this->belongsTo(Venta::class);
    }

}
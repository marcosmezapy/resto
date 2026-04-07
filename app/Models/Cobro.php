<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Cobro extends Model
{
    protected $fillable = [
        'venta_id',
        'cliente_id',
        'monto',
        'metodo_pago',
        'user_id'
    ];

    public function venta()
    {
        return $this->belongsTo(Venta::class);
    }

    public function cliente()
    {
        return $this->belongsTo(Cliente::class);
    }
}
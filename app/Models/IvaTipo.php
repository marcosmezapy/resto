<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class IvaTipo extends Model
{
    protected $table = 'iva_tipos';

    protected $fillable = [
        'nombre',
        'porcentaje'
    ];

    public function productos()
    {
        return $this->hasMany(PrdProducto::class, 'iva_tipo_id');
    }
}
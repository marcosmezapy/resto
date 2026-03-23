<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Compra extends Model
{
    protected $table = 'compras';

    protected $fillable = [
        'tenant_id',
        'sucursal_id',
        'proveedor_id',
        'numero_factura',
        'fecha',
        'total',
        'estado',
    ];

    // 🔗 Relaciones
    public function proveedor()
    {
        return $this->belongsTo(Proveedor::class);
    }

    public function detalles()
    {
        return $this->hasMany(CompraDetalle::class);
    }
}
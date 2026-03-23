<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Models\Traits\BelongsToTenant;
use App\Models\Traits\BelongsToSucursal;


class PrdStock extends Model
{
    use BelongsToTenant;
    use BelongsToSucursal;
    protected $table = 'prd_stocks';

    protected $fillable = [
        'producto_id',
        'deposito_id',
        'lote',
        'fecha_ingreso',
        'cantidad',
        'costo_compra',
         'proveedor_id', // 👈 ESTE ES EL QUE TE FALTA SEGURO
        'costo_venta',
        'codigo_barras',
    ];

    public function producto()
    {
        return $this->belongsTo(PrdProducto::class);
    }

    public function deposito()
    {
        return $this->belongsTo(PrdDeposito::class);
    }
    public function ventas()
    {
    return $this->hasMany(VentaDetalleLote::class,'stock_id');
    }

    public function proveedor()
    {
        return $this->belongsTo(\App\Models\Proveedor::class);
    }
}
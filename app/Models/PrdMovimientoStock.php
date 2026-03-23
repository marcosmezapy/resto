<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Models\Traits\BelongsToTenant;

class PrdMovimientoStock extends Model
{
    use BelongsToTenant;
    protected $table = 'prd_movimientos_stock';

    protected $fillable = [
        'producto_id',
        'deposito_id',
        'tipo',
        'cantidad',
        'costo_unitario',
        'lote',
        'descripcion'
    ];

    public function producto()
    {
        return $this->belongsTo(PrdProducto::class);
    }

    public function deposito()
    {
        return $this->belongsTo(PrdDeposito::class);
    }
}
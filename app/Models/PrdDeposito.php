<?php

// Producto.php
namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Models\Traits\BelongsToTenant;
use App\Models\Traits\BelongsToSucursal;

// Deposito.php
class PrdDeposito extends Model
{
    use BelongsToTenant;
    use BelongsToSucursal;
    protected $table = 'prd_depositos';
    protected $fillable = ['nombre','ubicacion','sucursal_id'];
    public function stocks() {
        return $this->hasMany(PrdStock::class,'deposito_id');
    }
    public function movimientos()
    {
        return $this->hasMany(PrdMovimientoStock::class,'deposito_id');
    }
    public function sucursal()
    {
        return $this->belongsTo(Sucursal::class);
    }

}


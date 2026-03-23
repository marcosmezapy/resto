<?php

// Producto.php
namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Models\Traits\BelongsToTenant;


// Clasificacion.php
class PrdClasificacion extends Model
{
    use BelongsToTenant;

    protected $table = 'prd_clasificaciones';
    protected $fillable = ['nombre','descripcion'];
    public function productos() {
        return $this->hasMany(PrdProducto::class,'clasificacion_id');
    }
}


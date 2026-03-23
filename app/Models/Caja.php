<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Models\Traits\BelongsToTenant;
use App\Models\Traits\BelongsToSucursal;

class Caja extends Model
{

    use BelongsToTenant;
    use BelongsToSucursal;
    protected $table = 'cajas';

    protected $fillable = [
        'nombre',
        'descripcion',
        'punto_expedicion_id',
        'activa',
        'sucursal_id' // 🔥
        
    ];

    public function sesiones()
    {
        return $this->hasMany(CajaSesion::class);
    }
    public function sucursal()
    {
        return $this->belongsTo(Sucursal::class);
    }
    public function puntoExpedicion()
    {
        return $this->belongsTo(PuntoExpedicion::class);
    }
}
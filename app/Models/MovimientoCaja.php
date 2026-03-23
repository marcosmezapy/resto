<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Models\Traits\BelongsToTenant;

class MovimientoCaja extends Model
{
    use BelongsToTenant;
    protected $table = 'movimientos_caja';

    protected $fillable = [
        'caja_sesion_id',
        'user_id',
        'tipo',
        'descripcion',
        'monto',
        'referencia_id'
    ];

    public function sesion()
    {
        return $this->belongsTo(CajaSesion::class,'caja_sesion_id');
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }

}
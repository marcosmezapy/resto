<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Timbrado extends Model
{
    protected $fillable = [
        'tenant_id','sucursal_id','punto_expedicion_id',
        'numero_timbrado','fecha_inicio','fecha_fin',
        'numero_inicio','numero_fin','ultimo_numero_usado',
        'estado','activo'
    ];

    public function generarNumero()
    {
        if ($this->ultimo_numero_usado >= $this->numero_fin) {
            $this->update(['estado' => 'agotado', 'activo' => false]);
            throw new \Exception('Timbrado agotado');
        }

        $numero = $this->ultimo_numero_usado + 1;

        $this->update([
            'ultimo_numero_usado' => $numero
        ]);

        return str_pad($numero, 7, '0', STR_PAD_LEFT);
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
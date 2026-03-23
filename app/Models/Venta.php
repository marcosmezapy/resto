<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Models\Traits\BelongsToTenant;

class Venta extends Model
{
    use BelongsToTenant;
    protected $table = 'ventas';

    protected $fillable = [
        'tipo_venta',
        'mesa_id',
        'usuario_id',
        'cliente_id',
        'caja_sesion_id',
        'total',
        'estado',
        'total_iva',
        'total_gravada_10',
        'total_gravada_5',
        'total_exenta',
        'sucursal_id',          // 🔥
        'timbrado_id',          // 🔥
        'punto_expedicion_id',  // 🔥
        'numero_factura',       // 🔥
        'tipo_documento',
        'numero_documento',
        'numero'
    ];

    public function detalles()
    {
        return $this->hasMany(VentaDetalle::class);
    }

    public function pagos()
    {
        return $this->hasMany(VentaPago::class);
    }

    public function mesa()
    {
        return $this->belongsTo(Mesa::class);
    }

    public function cliente()
    {
        return $this->belongsTo(Cliente::class);
    }    

    public function detalleLotes()
    {
        return $this->hasManyThrough(
            \App\Models\VentaDetalleLote::class,
            \App\Models\VentaDetalle::class,
            'venta_id',
            'venta_detalle_id'
        );
    }

    public function sucursal()
    {
        return $this->belongsTo(Sucursal::class);
    }

    public function timbrado()
    {
        return $this->belongsTo(Timbrado::class);
    }

    public function puntoExpedicion()
    {
        return $this->belongsTo(PuntoExpedicion::class);
    }
    public function cajaSesion()
    {
        return $this->belongsTo(CajaSesion::class);
    }
    public function usuario()
    {
        return $this->belongsTo(\App\Models\User::class, 'usuario_id');
    }
    public function tenant()
    {
        return $this->belongsTo(\App\Models\Tenant::class, 'tenant_id');
    }
}
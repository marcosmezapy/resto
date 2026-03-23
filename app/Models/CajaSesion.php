<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Models\Traits\BelongsToTenant;
use App\Models\Traits\BelongsToSucursal;


class CajaSesion extends Model
{

    use BelongsToTenant;
    use BelongsToSucursal;
    protected $table = 'caja_sesiones';

    protected $fillable = [

        'caja_id',
        'usuario_id',
        'monto_apertura',
        'monto_cierre',
        'monto_contado',
        'fecha_apertura',
        'fecha_cierre',
        'sucursal_id', // 🔥 IMPORTANTE
        'estado'

    ];

    protected $casts = [

        'fecha_apertura' => 'datetime',
        'fecha_cierre' => 'datetime'

    ];

    public function caja()
    {
        return $this->belongsTo(Caja::class);
    }

    public function usuario()
    {
        return $this->belongsTo(User::class,'usuario_id');
    }

    public function movimientos()
    {
        return $this->hasMany(MovimientoCaja::class);
    }
   
    public function totalMovimientos()
    {
        $ingresos = $this->movimientos()
            ->where('tipo','ingreso')
            ->sum('monto');

        $retiros = $this->movimientos()
            ->whereIn('tipo',['retiro','gasto'])
            ->sum('monto');

        return $ingresos - $retiros;
    }    

    public function ventas()
    {
        return $this->hasMany(Venta::class);
    }    


}
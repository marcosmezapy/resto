<?php

namespace App\Services\Caja;

use App\Models\CajaSesion;
use App\Models\Venta;
use App\Models\VentaPago;
use App\Models\MovimientoCaja;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class CajaSesionService
{

    public function getSesionActiva()
    {
        return CajaSesion::where('usuario_id', Auth::id())
            ->where('estado', 'abierta')
            ->where('sucursal_id', session('sucursal_id'))
            ->first();
    }

    public function validarCajaAbierta()
    {
        $sesion = $this->getSesionActiva();

        if(!$sesion){
            throw new \Exception("No hay una caja abierta");
        }

        return $sesion;
    }

    public function validarCajaDisponible($caja_id)
    {
        $existe = CajaSesion::where('caja_id', $caja_id)
            ->where('estado', 'abierta')
            ->exists();

        if($existe){
            throw new \Exception("Esta caja ya tiene una sesión abierta");
        }
    }

    public function abrir($caja_id, $monto_apertura)
    {
        return DB::transaction(function () use ($caja_id, $monto_apertura){

            $this->validarCajaDisponible($caja_id);

            $sesionUsuario = $this->getSesionActiva();

            if($sesionUsuario){
                throw new \Exception("Ya tienes una caja abierta");
            }

            return CajaSesion::create([
                'caja_id' => $caja_id,
                'usuario_id' => Auth::id(),
                'tenant_id' => Auth::user()->tenant_id ?? null,
                'sucursal_id' => session('sucursal_id'),
                'monto_apertura' => $monto_apertura,
                'estado' => 'abierta',
                'fecha_apertura' => now()
            ]);
        });
    }

    public function validarSinVentasAbiertas($cajaSesionId)
    {
        $ventas = Venta::where('caja_sesion_id', $cajaSesionId)
            ->where('estado','abierta')
            ->count();

        if($ventas > 0){
            throw new \Exception("No puedes cerrar la caja porque hay ventas abiertas");
        }
    }

    /*
    =====================================
    🔥 CAJA REAL = PAGOS
    =====================================
    */
    public function calcularTotales($cajaSesionId)
    {
        $efectivo = VentaPago::whereHas('venta', function($q) use($cajaSesionId){
            $q->where('caja_sesion_id', $cajaSesionId);
        })->where('metodo_pago','efectivo')->sum('monto');

        $tarjeta = VentaPago::whereHas('venta', function($q) use($cajaSesionId){
            $q->where('caja_sesion_id', $cajaSesionId);
        })->where('metodo_pago','tarjeta')->sum('monto');

        $transferencia = VentaPago::whereHas('venta', function($q) use($cajaSesionId){
            $q->where('caja_sesion_id', $cajaSesionId);
        })->where('metodo_pago','transferencia')->sum('monto');

        $ingresos = MovimientoCaja::where('caja_sesion_id',$cajaSesionId)
            ->where('tipo','ingreso')->sum('monto');

        $gastos = MovimientoCaja::where('caja_sesion_id',$cajaSesionId)
            ->where('tipo','gasto')->sum('monto');

        $retiros = MovimientoCaja::where('caja_sesion_id',$cajaSesionId)
            ->where('tipo','retiro')->sum('monto');

        return [
            'efectivo' => $efectivo,
            'tarjeta' => $tarjeta,
            'transferencia' => $transferencia,
            'ingresos' => $ingresos,
            'gastos' => $gastos,
            'retiros' => $retiros
        ];
    }

    public function cerrar($cajaSesionId, $monto_contado)
    {
        return DB::transaction(function () use ($cajaSesionId, $monto_contado){

            $sesion = CajaSesion::findOrFail($cajaSesionId);

            $this->validarSinVentasAbiertas($cajaSesionId);

            $sesion->update([
                'monto_contado' => $monto_contado,
                'estado' => 'cerrada',
                'fecha_cierre' => now()
            ]);

            return $sesion;
        });
    }

    public function getDashboardData($sesion)
    {
        $cajaSesionId = $sesion->id;

        $totales = $this->calcularTotales($cajaSesionId);

        $efectivo = $totales['efectivo'];
        $tarjeta = $totales['tarjeta'];
        $transferencia = $totales['transferencia'];

        $ingresos = $totales['ingresos'];
        $gastos = $totales['gastos'];
        $retiros = $totales['retiros'];

        $totalCobrado = $efectivo + $tarjeta + $transferencia;

        // 🔥 SOLO PARA INFO (NO CAJA)
        $totalVentas = Venta::where('caja_sesion_id',$cajaSesionId)
            ->where('estado','cerrada')
            ->sum('total');

        $ventasAbiertas = Venta::where('caja_sesion_id',$cajaSesionId)
            ->where('estado','abierta')
            ->get();

        $pendiente = $ventasAbiertas->sum('total');

        $cajaEsperada =
            $sesion->monto_apertura
            + $efectivo
            + $ingresos
            - $gastos
            - $retiros;

        $movimientos = MovimientoCaja::where('caja_sesion_id',$cajaSesionId)
            ->latest()
            ->get();

        $credito = Venta::where('caja_sesion_id',$cajaSesionId)
            ->where('condicion_pago','credito')
            ->where('estado','cerrada')
            ->sum('total');   

        return [
            'efectivo' => $efectivo,
            'tarjeta' => $tarjeta,
            'transferencia' => $transferencia,
            'totalCobrado' => $totalCobrado,
            'totalVentas' => $totalVentas,
            'cajaEsperada' => $cajaEsperada,
            'pendiente' => $pendiente,
            'ventasAbiertas' => $ventasAbiertas,
            'movimientos' => $movimientos,
            'ingresos' => $ingresos,
            'gastos' => $gastos,
            'retiros' => $retiros,
            'credito' => $credito
        ];
    }

    public function getCierreData($sesion)
    {
        $cajaSesionId = $sesion->id;

        $totales = $this->calcularTotales($cajaSesionId);

        $totalCobrado = 
            $totales['efectivo'] +
            $totales['tarjeta'] +
            $totales['transferencia'];

        $totalEsperado = 
            $sesion->monto_apertura
            + $totales['efectivo']
            + $totales['ingresos']
            - $totales['gastos']
            - $totales['retiros'];

        $movimientos = MovimientoCaja::where('caja_sesion_id',$cajaSesionId)
            ->latest()
            ->get();
        
        $credito = Venta::where('caja_sesion_id',$cajaSesionId)
            ->where('condicion_pago','credito')
            ->where('estado','cerrada')
            ->sum('total');       

        return [
            'efectivo' => $totales['efectivo'],
            'tarjeta' => $totales['tarjeta'],
            'transferencia' => $totales['transferencia'],
            'ingresos' => $totales['ingresos'],
            'gastos' => $totales['gastos'],
            'retiros' => $totales['retiros'],
            'totalCobrado' => $totalCobrado,
            'totalEsperado' => $totalEsperado,
            'movimientos' => $movimientos,
            'credito' => $credito
        ];
    }

    public function getDetalleCaja($cajaSesionId)
    {
        $caja = CajaSesion::with(['caja','usuario'])->findOrFail($cajaSesionId);

        $ventas = Venta::where('caja_sesion_id',$caja->id)
            ->with(['mesa','cliente','pagos'])
            ->orderBy('id','desc')
            ->get();

        $totales = $this->calcularTotales($cajaSesionId);

        $esperado =
            $caja->monto_apertura
            + $totales['efectivo']
            + $totales['ingresos']
            - $totales['gastos']
            - $totales['retiros'];

        $movimientos = MovimientoCaja::where('caja_sesion_id',$caja->id)
            ->latest()
            ->get();

        $credito = Venta::where('caja_sesion_id',$cajaSesionId)
            ->where('condicion_pago','credito')
            ->where('estado','cerrada')
            ->sum('total');    

        return [
            'caja' => $caja,
            'ventas' => $ventas,
            'efectivo' => $totales['efectivo'],
            'tarjeta' => $totales['tarjeta'],
            'transferencia' => $totales['transferencia'],
            'ingresos' => $totales['ingresos'],
            'gastos' => $totales['gastos'],
            'retiros' => $totales['retiros'],
            'esperado' => $esperado,
            'movimientos' => $movimientos,
            'credito' => $credito,
        ];
    }

    public function registrarMovimiento($tipo, $descripcion, $monto)
    {
        $sesion = $this->getSesionActiva();

        if(!$sesion){
            throw new \Exception("No hay caja abierta");
        }

        return MovimientoCaja::create([
            'caja_sesion_id' => $sesion->id,
            'user_id' => Auth::id(),
            'tipo' => $tipo,
            'descripcion' => $descripcion,
            'monto' => $monto
        ]);
    }

    public function puedeAbrirCaja()
    {
        return !$this->getSesionActiva();
    }
}
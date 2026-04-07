<?php

namespace App\Livewire\Reportes;

use Livewire\Component;
use App\Models\Venta;
use App\Models\VentaDetalle;
use App\Models\PrdProducto;
use Illuminate\Support\Facades\Auth;

class DashboardEjecutivo extends Component
{
    public function render()
    {
        $tenantId = Auth::user()->tenant_id;
        $sucursalId = session('sucursal_id');

        $hoy = now()->toDateString();

        // =========================
        // FILTRO BASE (IMPORTANTE)
        // =========================
        $ventasBase = Venta::where('tenant_id',$tenantId)
            ->where('sucursal_id',$sucursalId)
            ->where('estado','!=','cancelada');

        // =========================
        // VENTAS DEL DÍA
        // =========================
        $detallesHoy = VentaDetalle::whereHas('venta', function($q) use ($tenantId,$sucursalId,$hoy){
            $q->where('tenant_id',$tenantId)
              ->where('sucursal_id',$sucursalId)
              ->where('estado','cerrada')
              ->whereDate('created_at',$hoy);
        })->with('producto')->get();

        $ventaHoy = $detallesHoy->sum(fn($d)=> $d->precio * $d->cantidad);
        $costoHoy = $detallesHoy->sum(fn($d)=> ($d->costo_unitario ?? 0) * $d->cantidad);
        $utilidadHoy = $ventaHoy - $costoHoy;

        // =========================
        // MES ACTUAL VS ANTERIOR
        // =========================
        $ventaMes = $ventasBase
            ->where('estado','cerrada')
            ->whereMonth('created_at', now()->month)
            ->sum('total');

        $ventaMesAnterior = Venta::where('tenant_id',$tenantId)
            ->where('sucursal_id',$sucursalId)
            ->where('estado','cerrada')
            ->where('estado','!=','cancelada')
            ->whereMonth('created_at', now()->subMonth()->month)
            ->sum('total');

        // =========================
        // TICKET PROMEDIO
        // =========================
        $ventasHoyCount = Venta::where('tenant_id',$tenantId)
            ->where('sucursal_id',$sucursalId)
            ->where('estado','cerrada')
            ->whereDate('created_at',$hoy)
            ->count();

        $ticketPromedio = $ventasHoyCount > 0 ? $ventaHoy / $ventasHoyCount : 0;

        // =========================
        // PRODUCTOS VENDIDOS HOY
        // =========================
        $productosVendidosHoy = $detallesHoy->sum('cantidad');

        // =========================
        // CRÉDITO (🔥 NUEVO)
        // =========================
        $ventasCredito = Venta::where('tenant_id',$tenantId)
            ->where('sucursal_id',$sucursalId)
            ->where('estado','cerrada')
            ->where('condicion_pago','credito')
            ->sum('total');

        $deudaTotal = Venta::where('tenant_id',$tenantId)
            ->where('sucursal_id',$sucursalId)
            ->where('estado','cerrada')
            ->where('estado_pago','!=','pagado')
            ->where('estado_pago','!=','cancelado')
            ->sum('saldo');

        $deudaVencida = Venta::where('tenant_id',$tenantId)
            ->where('sucursal_id',$sucursalId)
            ->where('estado','cerrada')
            ->where('estado_pago','!=','pagado')
            ->where('estado_pago','!=','cancelado')
            ->whereNotNull('fecha_vencimiento')
            ->where('fecha_vencimiento','<',now())
            ->sum('saldo');

        $deudaNoVencida = $deudaTotal - $deudaVencida;

        // =========================
        // TENDENCIA 30 DÍAS
        // =========================
        $ventasPorDia = collect(range(0,29))->map(function($i) use ($tenantId,$sucursalId){
            $fecha = now()->subDays($i)->toDateString();

            $total = Venta::where('tenant_id',$tenantId)
                ->where('sucursal_id',$sucursalId)
                ->where('estado','cerrada')
                ->where('estado','!=','cancelada')
                ->whereDate('created_at',$fecha)
                ->sum('total');

            return ['fecha'=>$fecha,'total'=>$total];
        })->reverse()->values();

        // =========================
        // TOP PRODUCTOS
        // =========================
        $topProductos = VentaDetalle::selectRaw('producto_id, SUM(cantidad) as total')
            ->whereHas('venta', function($q) use ($tenantId,$sucursalId){
                $q->where('tenant_id',$tenantId)
                  ->where('sucursal_id',$sucursalId)
                  ->where('estado','cerrada');
            })
            ->with('producto')
            ->groupBy('producto_id')
            ->orderByDesc('total')
            ->limit(5)
            ->get();

        // =========================
        // HORAS PICO
        // =========================
        $horas = collect(range(0,23))->map(function($h) use ($tenantId,$sucursalId){
            $total = Venta::where('tenant_id',$tenantId)
                ->where('sucursal_id',$sucursalId)
                ->where('estado','cerrada')
                ->whereRaw('HOUR(created_at) = ?', [$h])
                ->count();

            return ['hora'=>$h,'total'=>$total];
        });

        // =========================
        // STOCK
        // =========================
        $productosStock = PrdProducto::where('tenant_id',$tenantId)
            ->where('es_stockeable',true)
            ->get()
            ->map(fn($p)=> $p->stocks()->where('sucursal_id',$sucursalId)->sum('cantidad'));

        $sinStock = $productosStock->filter(fn($s)=>$s==0)->count();
        $stockBajo = $productosStock->filter(fn($s)=>$s>0 && $s<=5)->count();

        return view('livewire.reportes.dashboard-ejecutivo', compact(
            'ventaHoy','costoHoy','utilidadHoy',
            'ventaMes','ventaMesAnterior',
            'ticketPromedio','productosVendidosHoy',
            'ventasCredito','deudaTotal','deudaVencida','deudaNoVencida',
            'ventasPorDia','topProductos','horas',
            'sinStock','stockBajo'
        ));
    }
}
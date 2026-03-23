<?php

namespace App\Livewire\Reportes;

use Livewire\Component;
use App\Models\VentaDetalle;
use Illuminate\Support\Facades\Auth;
use Carbon\Carbon;

class ReporteRentables extends Component
{
    public $fecha_inicio;
    public $fecha_fin;

    public function mount()
    {
        $this->fecha_inicio = now()->subDays(30)->format('Y-m-d');
        $this->fecha_fin = now()->format('Y-m-d');
    }

    public function render()
    {
        $tenantId = Auth::user()->tenant_id;
        $sucursalId = session('sucursal_id');

        $detalles = VentaDetalle::with(['producto','venta'])
            ->whereHas('venta', function($q) use ($tenantId,$sucursalId){
                $q->where('estado','pagada')
                  ->where('tenant_id',$tenantId)
                  ->where('sucursal_id',$sucursalId)
                  ->whereDate('created_at','>=',$this->fecha_inicio)
                  ->whereDate('created_at','<=',$this->fecha_fin);
            })
            ->get();

        $productos = $detalles->groupBy('producto_id')->map(function($items){

            $producto = $items->first()->producto;

            if(!$producto) return null;

            $ventas = $items->sum('subtotal');
            $cantidad = $items->sum('cantidad');
            $costo = $items->sum(fn($i)=>($i->producto->costo_base ?? 0) * $i->cantidad);
            $utilidad = $ventas - $costo;

            return [
                'nombre'=>$producto->nombre,
                'cantidad'=>$cantidad,
                'ventas'=>$ventas,
                'costo'=>$costo,
                'utilidad'=>$utilidad,
                'margen'=> $ventas > 0 ? ($utilidad / $ventas) * 100 : 0
            ];

        })->filter();

        // =========================
        // TOP / WORST
        // =========================
        $top = $productos->sortByDesc('utilidad')->take(5);
        $peores = $productos->sortBy('utilidad')->take(5);

        // =========================
        // KPI
        // =========================
        $totalVentas = $productos->sum('ventas');
        $totalCosto = $productos->sum('costo');
        $totalUtilidad = $productos->sum('utilidad');
        $margenGlobal = $totalVentas > 0 ? ($totalUtilidad / $totalVentas) * 100 : 0;

        return view('livewire.reportes.rentables',[
            'top'=>$top,
            'peores'=>$peores,
            'totalVentas'=>$totalVentas,
            'totalCosto'=>$totalCosto,
            'totalUtilidad'=>$totalUtilidad,
            'margenGlobal'=>$margenGlobal
        ]);
    }
}
<?php

namespace App\Livewire\Reportes;

use Livewire\Component;
use App\Models\VentaDetalle;
use Illuminate\Support\Facades\Auth;

class ReporteMasVendidos extends Component
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

        $detalles = VentaDetalle::with('producto')
            ->whereHas('venta', function($q) use ($tenantId,$sucursalId){
                $q->where('estado','pagada')
                  ->where('tenant_id',$tenantId)
                  ->where('sucursal_id',$sucursalId);
            })
            ->whereDate('created_at','>=',$this->fecha_inicio)
            ->whereDate('created_at','<=',$this->fecha_fin)
            ->get();

        $productos = $detalles->groupBy('producto_id')->map(function($items){

            $ventas = $items->sum('subtotal');
            $cantidad = $items->sum('cantidad');
            $costo = $items->sum(fn($i)=>($i->producto->costo_base ?? 0)*$i->cantidad);
            $utilidad = $ventas - $costo;

            return [
                'nombre'=>$items->first()->producto->nombre,
                'cantidad'=>$cantidad,
                'ventas'=>$ventas,
                'utilidad'=>$utilidad,
                'margen'=>$ventas > 0 ? ($utilidad/$ventas)*100 : 0
            ];
        });

        // TOP 5
        $top = $productos->sortByDesc('ventas')->take(5);

        // KPI
        $totalVentas = $productos->sum('ventas');
        $totalUtilidad = $productos->sum('utilidad');

        return view('livewire.reportes.mas-vendidos',[
            'top'=>$top,
            'totalVentas'=>$totalVentas,
            'totalUtilidad'=>$totalUtilidad
        ]);
    }
}
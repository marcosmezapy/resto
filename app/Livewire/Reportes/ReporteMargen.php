<?php

namespace App\Livewire\Reportes;

use Livewire\Component;
use App\Models\VentaDetalle;
use Illuminate\Support\Facades\Auth;

class ReporteMargen extends Component
{
    public $fecha_inicio;
    public $fecha_fin;
    public $producto_id = null;

    public function mount()
    {
        $this->fecha_inicio = now()->startOfMonth()->format('Y-m-d');
        $this->fecha_fin = now()->format('Y-m-d');
    }

    public function render()
    {
        $tenantId = Auth::user()->tenant_id;
        $sucursalId = session('sucursal_id');

        $query = VentaDetalle::with('producto')
            ->whereHas('venta', function($q) use ($tenantId,$sucursalId){
                $q->where('estado','pagada')
                  ->where('tenant_id',$tenantId)
                  ->where('sucursal_id',$sucursalId);
            })
            ->whereDate('created_at','>=',$this->fecha_inicio)
            ->whereDate('created_at','<=',$this->fecha_fin);

        if($this->producto_id){
            $query->where('producto_id',$this->producto_id);
        }

        $detalles = $query->get();

        // KPI
        $ventas = $detalles->sum('subtotal');
        $costos = $detalles->sum(fn($d)=> ($d->producto->costo_base ?? 0) * $d->cantidad);
        $utilidad = $ventas - $costos;
        $margen = $ventas > 0 ? ($utilidad / $ventas) * 100 : 0;

        // TOP RENTABLES
        $productos = $detalles->groupBy('producto_id')->map(function($items){
            $ventas = $items->sum('subtotal');
            $costo = $items->sum(fn($i)=>($i->producto->costo_base ?? 0)*$i->cantidad);
            return [
                'nombre'=>$items->first()->producto->nombre,
                'ventas'=>$ventas,
                'utilidad'=>$ventas - $costo
            ];
        })->sortByDesc('utilidad')->take(5);

        return view('livewire.reportes.margen', compact(
            'ventas','costos','utilidad','margen','productos'
        ));
    }
}
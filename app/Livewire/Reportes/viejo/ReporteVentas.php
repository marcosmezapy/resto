<?php

namespace App\Livewire\Reportes;

use Livewire\Component;
use App\Models\Venta;
use Illuminate\Support\Facades\Auth;

class ReporteVentas extends Component
{
    public $fecha_inicio;
    public $fecha_fin;

    public function mount()
    {
        $this->fecha_inicio = now()->startOfMonth()->format('Y-m-d');
        $this->fecha_fin = now()->format('Y-m-d');
    }

    public function render()
    {
        $tenantId = Auth::user()->tenant_id;
        $sucursalId = session('sucursal_id');

        $ventas = Venta::where('estado','pagada')
            ->where('tenant_id',$tenantId)
            ->where('sucursal_id',$sucursalId)
            ->whereDate('created_at','>=',$this->fecha_inicio)
            ->whereDate('created_at','<=',$this->fecha_fin)
            ->orderBy('created_at','desc')
            ->get();

        $totalVentas = $ventas->sum('total');
        $cantidadVentas = $ventas->count();
        $ticketPromedio = $cantidadVentas > 0 ? $totalVentas / $cantidadVentas : 0;

        return view('livewire.reportes.reporte-ventas',[
            'ventas'=>$ventas,
            'totalVentas'=>$totalVentas,
            'cantidadVentas'=>$cantidadVentas,
            'ticketPromedio'=>$ticketPromedio
        ]);
    }
}
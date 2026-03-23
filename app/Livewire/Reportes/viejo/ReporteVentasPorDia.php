<?php

namespace App\Livewire\Reportes;

use Livewire\Component;
use App\Models\Venta;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class ReporteVentasPorDia extends Component
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

        $ventas = Venta::select(
                DB::raw('DATE(created_at) as fecha'),
                DB::raw('COUNT(id) as cantidad_ventas'),
                DB::raw('SUM(total) as total_vendido')
            )
            ->where('estado','pagada')
            ->where('tenant_id',$tenantId)
            ->where('sucursal_id',$sucursalId)
            ->whereDate('created_at','>=',$this->fecha_inicio)
            ->whereDate('created_at','<=',$this->fecha_fin)
            ->groupBy(DB::raw('DATE(created_at)'))
            ->orderBy('fecha','asc')
            ->get();

        $totalGeneral = $ventas->sum('total_vendido');

        return view('livewire.reportes.reporte-ventas-por-dia',[
            'ventas'=>$ventas,
            'totalGeneral'=>$totalGeneral
        ]);
    }
}
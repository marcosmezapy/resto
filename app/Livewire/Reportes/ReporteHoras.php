<?php

namespace App\Livewire\Reportes;

use Livewire\Component;
use App\Models\Venta;
use Illuminate\Support\Facades\Auth;

class ReporteHoras extends Component
{
    public $fecha_inicio;
    public $fecha_fin;

    public function mount()
    {
        $this->fecha_inicio = now()->subDays(7)->format('Y-m-d');
        $this->fecha_fin = now()->format('Y-m-d');
    }

    public function render()
    {
        $tenantId = Auth::user()->tenant_id;
        $sucursalId = session('sucursal_id');

        $horas = collect(range(0,23))->map(function($h) use ($tenantId,$sucursalId){

            $ventas = Venta::where('estado','pagada')
                ->where('tenant_id',$tenantId)
                ->where('sucursal_id',$sucursalId)
                ->whereDate('created_at','>=',$this->fecha_inicio)
                ->whereDate('created_at','<=',$this->fecha_fin)
                ->whereRaw('HOUR(created_at)=?',[$h])
                ->get();

            $total = $ventas->sum('total');
            $cantidad = $ventas->count();

            return [
                'hora'=>$h,
                'total'=>$total,
                'cantidad'=>$cantidad
            ];
        });

        // KPI
        $totalVentas = $horas->sum('total');
        $totalTransacciones = $horas->sum('cantidad');

        // HORA MÁS FUERTE
        $horaTop = $horas->sortByDesc('total')->first();

        return view('livewire.reportes.horas',[
            'horas'=>$horas,
            'totalVentas'=>$totalVentas,
            'totalTransacciones'=>$totalTransacciones,
            'horaTop'=>$horaTop
        ]);
    }
}
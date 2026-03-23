<?php

namespace App\Livewire\Reportes;

use Livewire\Component;
use App\Models\Venta;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class ReporteDias extends Component
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

        // =========================
        // DATOS AGRUPADOS POR DÍA
        // =========================
        $ventas = Venta::select(
                DB::raw('DAYOFWEEK(created_at) as dia_num'),
                DB::raw('COUNT(*) as cantidad'),
                DB::raw('SUM(total) as total')
            )
            ->where('estado','pagada')
            ->where('tenant_id',$tenantId)
            ->where('sucursal_id',$sucursalId)
            ->whereDate('created_at','>=',$this->fecha_inicio)
            ->whereDate('created_at','<=',$this->fecha_fin)
            ->groupBy('dia_num')
            ->get()
            ->keyBy('dia_num');

        // =========================
        // ORDEN REAL DE LA SEMANA
        // =========================
        $diasSemana = [
            2 => 'Lunes',
            3 => 'Martes',
            4 => 'Miércoles',
            5 => 'Jueves',
            6 => 'Viernes',
            7 => 'Sábado',
            1 => 'Domingo',
        ];

        $resultado = collect($diasSemana)->map(function($nombre,$num) use ($ventas){

            $data = $ventas[$num] ?? null;

            return [
                'dia'=>$nombre,
                'total'=>$data->total ?? 0,
                'cantidad'=>$data->cantidad ?? 0,
                'ticket'=> ($data && $data->cantidad > 0)
                    ? $data->total / $data->cantidad
                    : 0
            ];
        });

        // =========================
        // KPI
        // =========================
        $mejor = $resultado->sortByDesc('total')->first();
        $peor = $resultado->sortBy('total')->first();

        return view('livewire.reportes.dias',[
            'dias'=>$resultado,
            'mejor'=>$mejor,
            'peor'=>$peor
        ]);
    }
}
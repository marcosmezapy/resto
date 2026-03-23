<?php

namespace App\Livewire\Reportes;

use Livewire\Component;
use App\Models\Venta;
use Illuminate\Support\Facades\Auth;

class ReporteTendencia extends Component
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
        // DATOS POR DÍA (SIN HUECOS)
        // =========================
        $datos = collect();

        $inicio = \Carbon\Carbon::parse($this->fecha_inicio);
        $fin = \Carbon\Carbon::parse($this->fecha_fin);

        while($inicio <= $fin){

            $fecha = $inicio->format('Y-m-d');

            $total = Venta::where('estado','pagada')
                ->where('tenant_id',$tenantId)
                ->where('sucursal_id',$sucursalId)
                ->whereDate('created_at',$fecha)
                ->sum('total');

            $cantidad = Venta::where('estado','pagada')
                ->where('tenant_id',$tenantId)
                ->where('sucursal_id',$sucursalId)
                ->whereDate('created_at',$fecha)
                ->count();

            $datos->push([
                'fecha'=>$fecha,
                'total'=>$total,
                'cantidad'=>$cantidad
            ]);

            $inicio->addDay();
        }

        // =========================
        // KPI
        // =========================
        $totalPeriodo = $datos->sum('total');
        $totalVentas = $datos->sum('cantidad');
        $ticketPromedio = $totalVentas > 0 ? $totalPeriodo / $totalVentas : 0;

        // =========================
        // VARIACIÓN (ÚLTIMOS 7 DÍAS)
        // =========================
        $ultimos = $datos->slice(-7)->sum('total');
        $anteriores = $datos->slice(-14,7)->sum('total');

        $variacion = $anteriores > 0 
            ? (($ultimos - $anteriores) / $anteriores) * 100 
            : 0;

        return view('livewire.reportes.tendencia',[
            'datos'=>$datos,
            'totalPeriodo'=>$totalPeriodo,
            'totalVentas'=>$totalVentas,
            'ticketPromedio'=>$ticketPromedio,
            'variacion'=>$variacion
        ]);
    }
}
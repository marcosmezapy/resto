<?php

namespace App\Livewire\Reportes;

use Livewire\Component;
use App\Models\Venta;
use Illuminate\Support\Facades\Auth;

class ReporteTicket extends Component
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
        // VENTAS
        // =========================
        $ventas = Venta::where('estado','pagada')
            ->where('tenant_id',$tenantId)
            ->where('sucursal_id',$sucursalId)
            ->whereDate('created_at','>=',$this->fecha_inicio)
            ->whereDate('created_at','<=',$this->fecha_fin)
            ->get();

        $totalVentas = $ventas->sum('total');
        $cantidadVentas = $ventas->count();

        $ticketPromedio = $cantidadVentas > 0 
            ? $totalVentas / $cantidadVentas 
            : 0;

        // =========================
        // TENDENCIA (POR DÍA)
        // =========================
        $datos = collect();

        $inicio = \Carbon\Carbon::parse($this->fecha_inicio);
        $fin = \Carbon\Carbon::parse($this->fecha_fin);

        while($inicio <= $fin){

            $fecha = $inicio->format('Y-m-d');

            $ventasDia = Venta::where('estado','pagada')
                ->where('tenant_id',$tenantId)
                ->where('sucursal_id',$sucursalId)
                ->whereDate('created_at',$fecha)
                ->get();

            $total = $ventasDia->sum('total');
            $cantidad = $ventasDia->count();

            $ticket = $cantidad > 0 ? $total / $cantidad : 0;

            $datos->push([
                'fecha'=>$fecha,
                'ticket'=>$ticket
            ]);

            $inicio->addDay();
        }

        // =========================
        // MEJOR Y PEOR DÍA
        // =========================
        $mejor = $datos->sortByDesc('ticket')->first();
        $peor = $datos->sortBy('ticket')->first();

        return view('livewire.reportes.ticket',[
            'ticketPromedio'=>$ticketPromedio,
            'totalVentas'=>$totalVentas,
            'cantidadVentas'=>$cantidadVentas,
            'datos'=>$datos,
            'mejor'=>$mejor,
            'peor'=>$peor
        ]);
    }
}
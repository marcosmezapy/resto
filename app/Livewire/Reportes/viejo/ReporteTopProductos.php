<?php

namespace App\Livewire\Reportes;

use Livewire\Component;
use App\Models\VentaDetalle;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class ReporteTopProductos extends Component
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

        $productos = VentaDetalle::select(
                'producto_id',
                DB::raw('SUM(cantidad) as total_vendido'),
                DB::raw('SUM(subtotal) as total_generado')
            )
            ->with('producto')
            ->whereHas('venta', function($q) use ($tenantId,$sucursalId){
                $q->where('estado','pagada')
                  ->where('tenant_id',$tenantId) // 🔥 FIX
                  ->where('sucursal_id',$sucursalId) // 🔥 FIX
                  ->whereDate('created_at','>=',$this->fecha_inicio)
                  ->whereDate('created_at','<=',$this->fecha_fin);
            })
            ->groupBy('producto_id')
            ->orderByDesc('total_generado')
            ->limit(10)
            ->get();

        $totalGenerado = $productos->sum('total_generado');

        return view('livewire.reportes.reporte-top-productos',[
            'productos'=>$productos,
            'totalGenerado'=>$totalGenerado
        ]);
    }
}
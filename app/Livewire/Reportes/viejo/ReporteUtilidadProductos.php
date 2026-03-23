<?php

namespace App\Livewire\Reportes;

use Livewire\Component;
use App\Models\VentaDetalle;
use Illuminate\Support\Facades\Auth;

class ReporteUtilidadProductos extends Component
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

        $detalles = VentaDetalle::with(['venta','producto'])
            ->whereHas('venta', function($q) use ($tenantId,$sucursalId){
                $q->where('estado','pagada')
                  ->where('tenant_id',$tenantId) // 🔥 FIX
                  ->where('sucursal_id',$sucursalId) // 🔥 FIX
                  ->whereDate('created_at','>=',$this->fecha_inicio)
                  ->whereDate('created_at','<=',$this->fecha_fin);
            })
            ->get();

        $productos = [];

        foreach($detalles as $detalle){

            $producto = $detalle->producto;

            if(!$producto) continue;

            $costo = ($producto->costo_base ?? 0) * $detalle->cantidad;
            $utilidad = $detalle->subtotal - $costo;

            if(!isset($productos[$producto->id])){
                $productos[$producto->id] = [
                    'nombre'=>$producto->nombre,
                    'unidades'=>0,
                    'ventas'=>0,
                    'costo'=>0,
                    'utilidad'=>0
                ];
            }

            $productos[$producto->id]['unidades'] += $detalle->cantidad;
            $productos[$producto->id]['ventas'] += $detalle->subtotal;
            $productos[$producto->id]['costo'] += $costo;
            $productos[$producto->id]['utilidad'] += $utilidad;
        }

        $productos = collect($productos)->sortByDesc('utilidad');

        $totalVentas = $productos->sum('ventas');
        $totalCosto = $productos->sum('costo');
        $totalUtilidad = $productos->sum('utilidad');

        return view('livewire.reportes.reporte-utilidad-productos',[
            'productos'=>$productos,
            'totalVentas'=>$totalVentas,
            'totalCosto'=>$totalCosto,
            'totalUtilidad'=>$totalUtilidad
        ]);
    }
}
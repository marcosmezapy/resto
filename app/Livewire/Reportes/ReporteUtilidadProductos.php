<?php

namespace App\Livewire\Reportes;

use Livewire\Component;
use App\Models\VentaDetalle;
use Illuminate\Support\Facades\Auth;

class ReporteUtilidadProductos extends Component
{
    public function render()
    {
        $tenantId = Auth::user()->tenant_id;
        $sucursalId = session('sucursal_id');

        $detalles = VentaDetalle::with(['venta','producto'])
            ->whereHas('venta', fn($q)=>$q->where('estado','pagada')
                ->where('tenant_id',$tenantId)
                ->where('sucursal_id',$sucursalId))
            ->get();

        $productos = [];

        foreach($detalles as $d){
            $p = $d->producto;
            if(!$p) continue;

            $costo = ($p->costo_base ?? 0)*$d->cantidad;
            $utilidad = $d->subtotal - $costo;

            if(!isset($productos[$p->id])){
                $productos[$p->id] = ['nombre'=>$p->nombre,'utilidad'=>0];
            }

            $productos[$p->id]['utilidad'] += $utilidad;
        }

        $productos = collect($productos)->sortByDesc('utilidad');

        return view('livewire.reportes.utilidad-productos', compact('productos'));
    }
}
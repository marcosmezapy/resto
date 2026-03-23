<?php

namespace App\Livewire\Reportes;

use Livewire\Component;
use App\Models\PrdProducto;
use App\Models\VentaDetalle;
use Illuminate\Support\Facades\Auth;
use Carbon\Carbon;

class ReporteSinRotacion extends Component
{
    public $dias = 30; // configurable

    public function render()
    {
        $tenantId = Auth::user()->tenant_id;
        $sucursalId = session('sucursal_id');

        $productos = PrdProducto::where('tenant_id',$tenantId)
            ->where('es_stockeable', true)
            ->get();

        $resultado = $productos->map(function($p) use ($sucursalId){

            // STOCK ACTUAL
            $stock = $p->stocks()
                ->where('sucursal_id',$sucursalId)
                ->sum('cantidad');

            // ÚLTIMA VENTA
            $ultimaVenta = VentaDetalle::where('producto_id',$p->id)
                ->whereHas('venta', function($q) use ($sucursalId){
                    $q->where('estado','pagada')
                      ->where('sucursal_id',$sucursalId);
                })
                ->latest('created_at')
                ->value('created_at');

            // DÍAS SIN VENTA
            if(!$ultimaVenta){
                $dias = 999;
                $texto = 'Nunca vendido';
            }else{
                $hoy = now()->startOfDay();
                $ultima = Carbon::parse($ultimaVenta)->startOfDay();
                $dias = $ultima->diffInDays($hoy);

                $texto = $dias == 0 ? 'Hoy' : $dias.' días';
            }

            // VALOR INMOVILIZADO
            $valor = $stock * ($p->costo_base ?? 0);

            return [
                'nombre'=>$p->nombre,
                'stock'=>$stock,
                'dias'=>$dias,
                'texto'=>$texto,
                'valor'=>$valor
            ];
        });

        // FILTRAR SOLO SIN ROTACIÓN REAL
        $sinRotacion = $resultado
            ->filter(fn($p)=> $p['dias'] >= $this->dias && $p['stock'] > 0)
            ->sortByDesc('valor')
            ->values();

        // KPI
        $totalProductos = $sinRotacion->count();
        $dineroDormido = $sinRotacion->sum('valor');

        return view('livewire.reportes.sin-rotacion',[
            'productos'=>$sinRotacion,
            'totalProductos'=>$totalProductos,
            'dineroDormido'=>$dineroDormido
        ]);
    }
}
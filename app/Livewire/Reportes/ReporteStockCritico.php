<?php

namespace App\Livewire\Reportes;

use Livewire\Component;
use App\Models\PrdProducto;
use App\Models\VentaDetalle;
use Illuminate\Support\Facades\Auth;

class ReporteStockCritico extends Component
{
    public $dias_muerto = 30;
    public $dias_lento = 15;


public function render()
{
    $tenantId = Auth::user()->tenant_id;
    $sucursalId = session('sucursal_id');

    $productos = \App\Models\PrdProducto::where('tenant_id',$tenantId)
        ->where('es_stockeable', true)
        ->get();

    $resultado = $productos->map(function($p) use ($sucursalId){

        // =========================
        // STOCK
        // =========================
        $stock = $p->stocks()
            ->where('sucursal_id',$sucursalId)
            ->sum('cantidad');

        // =========================
        // ÚLTIMA VENTA
        // =========================
        $ultimaVenta = \App\Models\VentaDetalle::where('producto_id',$p->id)
            ->whereHas('venta', function($q) use ($sucursalId){
                $q->where('estado','pagada')
                  ->where('sucursal_id',$sucursalId);
            })
            ->latest('created_at')
            ->value('created_at');

        // =========================
        // DÍAS SIN VENTA (100% HUMANO)
        // =========================
        if(!$ultimaVenta){

            $diasSinVenta = null;
            $diasTexto = 'Nunca vendido';

        }else{

            // 🔥 CLAVE: SOLO FECHAS (NO HORAS)
            $hoy = now()->startOfDay();
            $ultima = \Carbon\Carbon::parse($ultimaVenta)->startOfDay();

            $dias = $ultima->diffInDays($hoy); // SIEMPRE ENTERO

            $diasSinVenta = $dias;

            if($dias == 0){
                $diasTexto = 'Hoy';
            }elseif($dias == 1){
                $diasTexto = '1 día';
            }elseif($dias <= 30){
                $diasTexto = $dias . ' días';
            }else{
                $diasTexto = '+30 días';
            }
        }

        // =========================
        // VENTAS 30 DÍAS
        // =========================
        $ventas30 = \App\Models\VentaDetalle::where('producto_id',$p->id)
            ->whereHas('venta', function($q) use ($sucursalId){
                $q->where('estado','pagada')
                  ->where('sucursal_id',$sucursalId)
                  ->whereDate('created_at','>=', now()->subDays(30));
            })
            ->sum('cantidad');

        // =========================
        // ROTACIÓN
        // =========================
        $rotacion = $ventas30 / 30;

        // =========================
        // ESTADO
        // =========================
        if($stock == 0){
            $estado = 'CRITICO';
        }
        elseif($diasSinVenta !== null && $diasSinVenta >= 30){
            $estado = 'MUERTO';
        }
        elseif($diasSinVenta !== null && $diasSinVenta >= 15){
            $estado = 'LENTO';
        }
        elseif($rotacion > 0 && $stock <= ($rotacion * 3)){
            $estado = 'RIESGO';
        }
        else{
            $estado = 'SALUDABLE';
        }

        return [
            'nombre'=>$p->nombre,
            'stock'=>$stock,
            'ventas30'=>$ventas30,
            'diasSinVenta'=>$diasSinVenta,
            'diasTexto'=>$diasTexto,
            'estado'=>$estado
        ];
    });

    $ordenado = $resultado->sortBy(function($p){
        return match($p['estado']){
            'CRITICO' => 1,
            'RIESGO' => 2,
            'MUERTO' => 3,
            'LENTO' => 4,
            default => 5
        };
    })->values();

    return view('livewire.reportes.stock-critico', [
        'productos'=>$ordenado
    ]);
}

}
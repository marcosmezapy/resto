<?php

namespace App\Livewire\Reportes;

use Livewire\Component;
use Livewire\WithPagination;
use App\Models\Venta;
use App\Models\Cliente;

class ReporteDeudas extends Component
{
    use WithPagination;

    protected $paginationTheme = 'bootstrap';

    public $cliente_id;
    public $estado; // vencido | al_dia
    public $fecha_desde;
    public $fecha_hasta;

    public function updating($field)
    {
        $this->resetPage();
    }

    public function render()
    {
        $query = Venta::with('cliente')
            ->where('estado_pago','!=','pagado');

        // 🔎 FILTROS
        if($this->cliente_id){
            $query->where('cliente_id',$this->cliente_id);
        }

        if($this->estado == 'vencido'){
            $query->where('fecha_vencimiento','<',now());
        }

        if($this->estado == 'al_dia'){
            $query->where(function($q){
                $q->whereNull('fecha_vencimiento')
                  ->orWhere('fecha_vencimiento','>=',now());
            });
        }

        if($this->fecha_desde){
            $query->whereDate('created_at','>=',$this->fecha_desde);
        }

        if($this->fecha_hasta){
            $query->whereDate('created_at','<=',$this->fecha_hasta);
        }

        $ventas = $query->orderBy('created_at','desc')->paginate(20);

        // 🔥 KPIs
        $totalDeuda = $query->sum('saldo');

        $totalVencido = (clone $query)
            ->where('fecha_vencimiento','<',now())
            ->sum('saldo');

        $cantidad = (clone $query)->count();

        $vencidas = (clone $query)
            ->where('fecha_vencimiento','<',now())
            ->count();

        $clientes = Cliente::orderBy('nombre')->get();

        return view('livewire.reportes.reporte-deudas',[
            'ventas'=>$ventas,
            'totalDeuda'=>$totalDeuda,
            'totalVencido'=>$totalVencido,
            'cantidad'=>$cantidad,
            'vencidas'=>$vencidas,
            'clientes'=>$clientes
        ]);
    }
}
<?php

namespace App\Livewire\Reportes;

use Livewire\Component;
use App\Models\VentaDetalle;
use Illuminate\Support\Facades\DB;

class ReporteProductosVendidos extends Component
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

$productos = VentaDetalle::select(
'producto_id',
DB::raw('SUM(cantidad) as total_vendido'),
DB::raw('SUM(subtotal) as total_generado')
)
->with('producto')
->whereHas('venta', function($q){

$q->where('estado','pagada')
->whereDate('created_at','>=',$this->fecha_inicio)
->whereDate('created_at','<=',$this->fecha_fin);

})
->groupBy('producto_id')
->orderByDesc('total_vendido')
->get();

return view('livewire.reportes.reporte-productos-vendidos',[
'productos'=>$productos
]);

}

}
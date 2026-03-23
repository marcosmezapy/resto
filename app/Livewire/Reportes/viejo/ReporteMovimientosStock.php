<?php

namespace App\Livewire\Reportes;

use Livewire\Component;
use App\Models\PrdMovimientoStock;

class ReporteMovimientosStock extends Component
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

$movimientos = PrdMovimientoStock::with('producto')
->whereDate('created_at','>=',$this->fecha_inicio)
->whereDate('created_at','<=',$this->fecha_fin)
->orderBy('created_at','desc')
->get();

$totalEntradas = $movimientos->where('cantidad','>',0)->sum('cantidad');
$totalSalidas = abs($movimientos->where('cantidad','<',0)->sum('cantidad'));

return view('livewire.reportes.reporte-movimientos-stock',[
'movimientos'=>$movimientos,
'totalEntradas'=>$totalEntradas,
'totalSalidas'=>$totalSalidas
]);

}

}
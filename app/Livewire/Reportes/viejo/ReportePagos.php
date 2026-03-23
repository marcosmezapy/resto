<?php

namespace App\Livewire\Reportes;

use Livewire\Component;
use App\Models\VentaPago;
use Illuminate\Support\Facades\DB;

class ReportePagos extends Component
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

$pagos = VentaPago::select(
'metodo_pago',
DB::raw('SUM(monto) as total')
)
->whereHas('venta', function($q){

$q->where('estado','pagada')
->whereDate('created_at','>=',$this->fecha_inicio)
->whereDate('created_at','<=',$this->fecha_fin);

})
->groupBy('metodo_pago')
->get();

$totalGeneral = $pagos->sum('total');

return view('livewire.reportes.reporte-pagos',[
'pagos'=>$pagos,
'totalGeneral'=>$totalGeneral
]);

}

}
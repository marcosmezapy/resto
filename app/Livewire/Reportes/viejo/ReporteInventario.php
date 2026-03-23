<?php

namespace App\Livewire\Reportes;

use Livewire\Component;
use App\Models\PrdProducto;
use Illuminate\Support\Facades\DB;

class ReporteInventario extends Component
{

public $buscar = '';

public function render()
{

$query = PrdProducto::query()
->where('es_stockeable',true);

if($this->buscar){

$query->where('nombre','like','%'.$this->buscar.'%');

}

$productos = $query
->withSum('stocks','cantidad')
->with(['stocks'])
->get();

$valorInventario = 0;

foreach($productos as $producto){

$costoPromedio = $producto->stocks->avg('costo_compra');

$valorInventario += ($producto->stocks_sum_cantidad ?? 0) * $costoPromedio;

}

return view('livewire.reportes.reporte-inventario',[
'productos'=>$productos,
'valorInventario'=>$valorInventario
]);

}

}
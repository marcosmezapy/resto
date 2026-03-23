<?php

namespace App\Livewire\Reportes;

use Livewire\Component;
use App\Models\PrdProducto;

class ReporteSinStock extends Component
{

public function render()
{

$productos = PrdProducto::where('es_stockeable',true)
->withSum('stocks','cantidad')
->get();

$sinStock = $productos->where('stocks_sum_cantidad',0);
$stockBajo = $productos->where('stocks_sum_cantidad','>',0)
                       ->where('stocks_sum_cantidad','<=',5);

return view('livewire.reportes.reporte-sin-stock',[
'productosSinStock'=>$sinStock,
'productosStockBajo'=>$stockBajo
]);

}

}
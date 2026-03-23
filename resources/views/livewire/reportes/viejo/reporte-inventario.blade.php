<div>

<div class="card shadow-sm">

<div class="card-header bg-white">

<div class="row">

<div class="col-md-6">

<h4 class="mb-0">
Inventario actual
</h4>

<small class="text-muted">
Estado actual del stock de productos
</small>

</div>

<div class="col-md-6 text-right">

<input
type="text"
class="form-control form-control-sm w-50 d-inline"
placeholder="Buscar producto..."
wire:model.live="buscar">

</div>

</div>

</div>


<div class="card-body">

<div class="row mb-3">

<div class="col-md-4">

<div class="info-box bg-info">

<span class="info-box-icon">
<i class="fas fa-box"></i>
</span>

<div class="info-box-content">

<span class="info-box-text">
Productos en inventario
</span>

<span class="info-box-number">
{{ $productos->count() }}
</span>

</div>

</div>

</div>


<div class="col-md-4">

<div class="info-box bg-success">

<span class="info-box-icon">
<i class="fas fa-warehouse"></i>
</span>

<div class="info-box-content">

<span class="info-box-text">
Unidades en stock
</span>

<span class="info-box-number">

{{ $productos->sum('stocks_sum_cantidad') }}

</span>

</div>

</div>

</div>


<div class="col-md-4">

<div class="info-box bg-warning">

<span class="info-box-icon">
<i class="fas fa-dollar-sign"></i>
</span>

<div class="info-box-content">

<span class="info-box-text">
Valor del inventario
</span>

<span class="info-box-number">

Gs. {{ number_format($valorInventario,0,',','.') }}

</span>

</div>

</div>

</div>

</div>


<table class="table table-sm table-hover table-bordered">

<thead class="thead-light">

<tr>

<th>Producto</th>
<th width="120">Stock</th>
<th width="160">Costo promedio</th>
<th width="160">Valor inventario</th>

</tr>

</thead>

<tbody>

@foreach($productos as $producto)

@php

$costoPromedio = $producto->stocks->avg('costo_compra');

$stock = $producto->stocks_sum_cantidad ?? 0;

$valor = $stock * $costoPromedio;

@endphp

<tr>

<td>

<b>{{ $producto->nombre }}</b>

</td>

<td>

@if($stock <= 5)

<span class="badge badge-danger">
{{ $stock }}
</span>

@elseif($stock <= 10)

<span class="badge badge-warning">
{{ $stock }}
</span>

@else

<span class="badge badge-success">
{{ $stock }}
</span>

@endif

</td>

<td>

Gs. {{ number_format($costoPromedio,0,',','.') }}

</td>

<td>

Gs. {{ number_format($valor,0,',','.') }}

</td>

</tr>

@endforeach

</tbody>

</table>

</div>

</div>

</div>
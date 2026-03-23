<div>

<div class="card shadow-sm">

<div class="card-header bg-white">

<div class="row">

<div class="col-md-6">

<h4 class="mb-0">
Movimientos de stock
</h4>

<small class="text-muted">
Historial completo de inventario
</small>

</div>

<div class="col-md-6 text-right">

<input
type="date"
class="form-control form-control-sm d-inline w-auto"
wire:model.live="fecha_inicio">

<input
type="date"
class="form-control form-control-sm d-inline w-auto"
wire:model.live="fecha_fin">

</div>

</div>

</div>

<div class="card-body">

<div class="row mb-4">

<div class="col-md-6">

<div class="info-box bg-success">

<span class="info-box-icon">
<i class="fas fa-arrow-down"></i>
</span>

<div class="info-box-content">

<span class="info-box-text">
Entradas
</span>

<span class="info-box-number">
{{ $totalEntradas }}
</span>

</div>

</div>

</div>

<div class="col-md-6">

<div class="info-box bg-danger">

<span class="info-box-icon">
<i class="fas fa-arrow-up"></i>
</span>

<div class="info-box-content">

<span class="info-box-text">
Salidas
</span>

<span class="info-box-number">
{{ $totalSalidas }}
</span>

</div>

</div>

</div>

</div>


<table class="table table-bordered table-hover">

<thead class="thead-light">

<tr>

<th>Fecha</th>
<th>Producto</th>
<th>Tipo</th>
<th>Cantidad</th>
<th>Costo</th>

</tr>

</thead>

<tbody>

@foreach($movimientos as $mov)

<tr>

<td>

{{ $mov->created_at }}

</td>

<td>

<b>{{ $mov->producto->nombre }}</b>

</td>

<td>

@if($mov->cantidad > 0)

<span class="badge badge-success">
Entrada
</span>

@else

<span class="badge badge-danger">
Salida
</span>

@endif

</td>

<td>

{{ $mov->cantidad }}

</td>

<td>

Gs. {{ number_format($mov->costo_total ?? 0,0,',','.') }}

</td>

</tr>

@endforeach

</tbody>

</table>

</div>

</div>

</div>
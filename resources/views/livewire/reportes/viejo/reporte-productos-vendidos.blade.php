<div>

<div class="card">

<div class="card-header">
<b>Reporte de Productos Vendidos</b>
</div>

<div class="card-body">

<div class="row mb-3">

<div class="col-md-3">

<label>Fecha inicio</label>

<input
type="date"
class="form-control"
wire:model.live="fecha_inicio">

</div>

<div class="col-md-3">

<label>Fecha fin</label>

<input
type="date"
class="form-control"
wire:model.live="fecha_fin">

</div>

</div>


<table class="table table-sm table-bordered">

<thead>

<tr>

<th>Producto</th>
<th>Cantidad vendida</th>
<th>Total generado</th>

</tr>

</thead>

<tbody>

@foreach($productos as $item)

<tr>

<td>{{ $item->producto->nombre ?? 'Producto eliminado' }}</td>

<td>{{ $item->total_vendido }}</td>

<td>
Gs. {{ number_format($item->total_generado,0,',','.') }}
</td>

</tr>

@endforeach

</tbody>

</table>

</div>

</div>

</div>
<div>

<div class="card shadow-sm">

<div class="card-header">
<b>Reporte de Ventas</b>
</div>

<div class="card-body">

<!-- FILTROS -->
<div class="row mb-3">

<div class="col-md-3">
<label>Fecha inicio</label>
<input type="date" class="form-control" wire:model.live="fecha_inicio">
</div>

<div class="col-md-3">
<label>Fecha fin</label>
<input type="date" class="form-control" wire:model.live="fecha_fin">
</div>

</div>

<!-- KPI -->
<div class="row mb-3">

<div class="col-md-4">
<div class="alert alert-info">
Ventas: <b>{{ $cantidadVentas }}</b>
</div>
</div>

<div class="col-md-4">
<div class="alert alert-success">
Total: <b>Gs. {{ number_format($totalVentas,0,',','.') }}</b>
</div>
</div>

<div class="col-md-4">
<div class="alert alert-warning">
Ticket promedio: <b>Gs. {{ number_format($ticketPromedio,0,',','.') }}</b>
</div>
</div>

</div>

<!-- TABLA -->
<table class="table table-sm table-hover">

<thead>
<tr>
<th>ID</th>
<th>Fecha</th>
<th>Total</th>
</tr>
</thead>

<tbody>
@foreach($ventas as $venta)
<tr>
<td>{{ $venta->id }}</td>
<td>{{ $venta->created_at->format('d/m/Y H:i') }}</td>
<td>Gs. {{ number_format($venta->total,0,',','.') }}</td>
</tr>
@endforeach
</tbody>

</table>

</div>

</div>

</div>
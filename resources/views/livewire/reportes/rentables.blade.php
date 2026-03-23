<div>

<div class="card shadow-sm">

<div class="card-header">
<b>Utilidad real del negocio</b>
</div>

<div class="card-body">

<!-- FILTROS -->
<div class="row mb-4">

<div class="col-md-3">
<label>Desde</label>
<input type="date" class="form-control" wire:model.live="fecha_inicio">
</div>

<div class="col-md-3">
<label>Hasta</label>
<input type="date" class="form-control" wire:model.live="fecha_fin">
</div>

</div>

<!-- KPI -->
<div class="row text-center mb-4">

<div class="col-md-3">
<div class="card bg-primary text-white">
<div class="card-body">
<h5>Ventas</h5>
<h3>Gs {{ number_format($totalVentas,0,',','.') }}</h3>
</div>
</div>
</div>

<div class="col-md-3">
<div class="card bg-warning text-white">
<div class="card-body">
<h5>Costos</h5>
<h3>Gs {{ number_format($totalCosto,0,',','.') }}</h3>
</div>
</div>
</div>

<div class="col-md-3">
<div class="card bg-success text-white">
<div class="card-body">
<h5>Utilidad</h5>
<h3>Gs {{ number_format($totalUtilidad,0,',','.') }}</h3>
</div>
</div>
</div>

<div class="col-md-3">
<div class="card bg-dark text-white">
<div class="card-body">
<h5>Margen</h5>
<h3>{{ number_format($margenGlobal,1) }}%</h3>
</div>
</div>
</div>

</div>

<!-- TOP -->
<div class="card mb-4">
<div class="card-header">
<b>Productos más rentables</b>
</div>

<div class="card-body p-0">

<table class="table table-hover mb-0">

<thead>
<tr>
<th>Producto</th>
<th class="text-end">Utilidad</th>
<th class="text-end">Margen</th>
</tr>
</thead>

<tbody>

@foreach($top as $p)

<tr>
<td>{{ $p['nombre'] }}</td>

<td class="text-end text-success">
Gs {{ number_format($p['utilidad'],0,',','.') }}
</td>

<td class="text-end">
{{ number_format($p['margen'],1) }}%
</td>
</tr>

@endforeach

</tbody>

</table>

</div>
</div>

<!-- PEORES -->
<div class="card">
<div class="card-header">
<b>Productos con peor rendimiento</b>
</div>

<div class="card-body p-0">

<table class="table table-hover mb-0">

<thead>
<tr>
<th>Producto</th>
<th class="text-end">Utilidad</th>
<th class="text-end">Margen</th>
</tr>
</thead>

<tbody>

@foreach($peores as $p)

<tr>
<td>{{ $p['nombre'] }}</td>

<td class="text-end text-danger">
Gs {{ number_format($p['utilidad'],0,',','.') }}
</td>

<td class="text-end">
{{ number_format($p['margen'],1) }}%
</td>

</tr>

@endforeach

</tbody>

</table>

</div>
</div>

</div>

</div>

</div>
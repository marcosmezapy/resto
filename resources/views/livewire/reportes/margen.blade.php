<div>

<div class="card shadow-sm">

<div class="card-header">
<b>Margen y rentabilidad</b>
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
<div class="card bg-info text-white">
<div class="card-body">
<h5>Ventas</h5>
<h3>Gs {{ number_format($ventas,0,',','.') }}</h3>
</div>
</div>
</div>

<div class="col-md-3">
<div class="card bg-warning text-white">
<div class="card-body">
<h5>Costos</h5>
<h3>Gs {{ number_format($costos,0,',','.') }}</h3>
</div>
</div>
</div>

<div class="col-md-3">
<div class="card bg-success text-white">
<div class="card-body">
<h5>Utilidad</h5>
<h3>Gs {{ number_format($utilidad,0,',','.') }}</h3>
</div>
</div>
</div>

<div class="col-md-3">
<div class="card bg-dark text-white">
<div class="card-body">
<h5>Margen</h5>
<h3>{{ number_format($margen,1) }}%</h3>
</div>
</div>
</div>

</div>

<!-- TOP RENTABLES -->
<div class="card">
<div class="card-header">
<b>Top productos más rentables</b>
</div>

<div class="card-body p-0">

<table class="table table-hover mb-0">

<thead>
<tr>
<th>Producto</th>
<th class="text-end">Ventas</th>
<th class="text-end">Utilidad</th>
</tr>
</thead>

<tbody>

@foreach($productos as $p)

<tr>
<td>{{ $p['nombre'] }}</td>
<td class="text-end">Gs {{ number_format($p['ventas'],0,',','.') }}</td>
<td class="text-end text-success">
Gs {{ number_format($p['utilidad'],0,',','.') }}
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
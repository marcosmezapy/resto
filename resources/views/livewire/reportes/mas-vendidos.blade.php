<div>

<div class="card shadow-sm">

<div class="card-header">
<b>Top productos (impacto en el negocio)</b>
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

<div class="col-md-6">
<div class="card bg-primary text-white">
<div class="card-body">
<h5>Total ventas</h5>
<h3>Gs {{ number_format($totalVentas,0,',','.') }}</h3>
</div>
</div>
</div>

<div class="col-md-6">
<div class="card bg-success text-white">
<div class="card-body">
<h5>Utilidad generada</h5>
<h3>Gs {{ number_format($totalUtilidad,0,',','.') }}</h3>
</div>
</div>
</div>

</div>

<!-- TABLA EJECUTIVA -->
<div class="card">
<div class="card-header">
<b>Top 5 productos</b>
</div>

<div class="card-body p-0">

<table class="table table-hover mb-0">

<thead>
<tr>
<th>#</th>
<th>Producto</th>
<th class="text-end">Unidades</th>
<th class="text-end">Ventas</th>
<th class="text-end">Utilidad</th>
<th class="text-end">Margen</th>
</tr>
</thead>

<tbody>

@foreach($top as $i => $p)

<tr>
<td><b>{{ $i+1 }}</b></td>
<td>{{ $p['nombre'] }}</td>
<td class="text-end">{{ $p['cantidad'] }}</td>
<td class="text-end">Gs {{ number_format($p['ventas'],0,',','.') }}</td>

<td class="text-end {{ $p['utilidad'] >= 0 ? 'text-success' : 'text-danger' }}">
Gs {{ number_format($p['utilidad'],0,',','.') }}
</td>

<td class="text-end">
<span class="badge {{ $p['margen'] > 30 ? 'bg-success' : 'bg-warning' }}">
{{ number_format($p['margen'],1) }}%
</span>
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
<div>

<div class="card shadow-sm">

<div class="card-header d-flex justify-content-between">
<div>
<h5 class="mb-0">Utilidad por producto</h5>
<small class="text-muted">Rentabilidad real</small>
</div>

<div>
<input type="date" class="form-control form-control-sm d-inline w-auto" wire:model.live="fecha_inicio">
<input type="date" class="form-control form-control-sm d-inline w-auto" wire:model.live="fecha_fin">
</div>
</div>

<div class="card-body">

<div class="row mb-3">

<div class="col-md-4">
<div class="alert alert-info">
Ventas: <b>Gs. {{ number_format($totalVentas,0,',','.') }}</b>
</div>
</div>

<div class="col-md-4">
<div class="alert alert-warning">
Costo: <b>Gs. {{ number_format($totalCosto,0,',','.') }}</b>
</div>
</div>

<div class="col-md-4">
<div class="alert alert-success">
Utilidad: <b>Gs. {{ number_format($totalUtilidad,0,',','.') }}</b>
</div>
</div>

</div>

<table class="table table-hover">

<thead>
<tr>
<th>Producto</th>
<th class="text-end">Unidades</th>
<th class="text-end">Ventas</th>
<th class="text-end">Costo</th>
<th class="text-end">Utilidad</th>
</tr>
</thead>

<tbody>

@foreach($productos as $p)

<tr>
<td>{{ $p['nombre'] }}</td>
<td class="text-end">{{ $p['unidades'] }}</td>
<td class="text-end">Gs. {{ number_format($p['ventas'],0,',','.') }}</td>
<td class="text-end">Gs. {{ number_format($p['costo'],0,',','.') }}</td>
<td class="text-end">
<span class="{{ $p['utilidad'] >= 0 ? 'text-success' : 'text-danger' }}">
Gs. {{ number_format($p['utilidad'],0,',','.') }}
</span>
</td>
</tr>

@endforeach

</tbody>

</table>

</div>

</div>

</div>
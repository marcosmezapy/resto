<div>

<div class="card shadow-sm">

<div class="card-header d-flex justify-content-between">
<div>
<h5 class="mb-0">Top productos</h5>
<small class="text-muted">Ranking por facturación</small>
</div>

<div>
<input type="date" class="form-control form-control-sm d-inline w-auto" wire:model.live="fecha_inicio">
<input type="date" class="form-control form-control-sm d-inline w-auto" wire:model.live="fecha_fin">
</div>
</div>

<div class="card-body">

<div class="alert alert-info">
Total generado: <b>Gs. {{ number_format($totalGenerado,0,',','.') }}</b>
</div>

</div>

<div class="table-responsive">

<table class="table table-hover mb-0">

<thead>
<tr>
<th>#</th>
<th>Producto</th>
<th class="text-end">Unidades</th>
<th class="text-end">Total</th>
</tr>
</thead>

<tbody>

@foreach($productos as $i => $item)

<tr>
<td><b>{{ $i+1 }}</b></td>
<td>{{ $item->producto->nombre ?? 'Eliminado' }}</td>
<td class="text-end">{{ $item->total_vendido }}</td>
<td class="text-end">Gs. {{ number_format($item->total_generado,0,',','.') }}</td>
</tr>

@endforeach

</tbody>

</table>

</div>

</div>

</div>
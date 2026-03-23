<div>

<div class="card shadow-sm">

<div class="card-header">
<h5 class="mb-0">Ventas por día</h5>
</div>

<div class="card-body p-0">

<div class="p-2">
<input type="date" class="form-control form-control-sm d-inline w-auto" wire:model.live="fecha_inicio">
<input type="date" class="form-control form-control-sm d-inline w-auto" wire:model.live="fecha_fin">
</div>

<table class="table table-hover mb-0">

<thead>
<tr>
<th>Fecha</th>
<th>Ventas</th>
<th>Total</th>
<th>Ticket</th>
</tr>
</thead>

<tbody>

@foreach($ventas as $venta)

<tr>
<td><b>{{ \Carbon\Carbon::parse($venta->fecha)->format('d/m/Y') }}</b></td>
<td>{{ $venta->cantidad_ventas }}</td>
<td>Gs. {{ number_format($venta->total_vendido,0,',','.') }}</td>
<td>
Gs. {{ number_format($venta->total_vendido / max($venta->cantidad_ventas,1),0,',','.') }}
</td>
</tr>

@endforeach

</tbody>

<tfoot>
<tr>
<th>Total</th>
<th></th>
<th>Gs. {{ number_format($totalGeneral,0,',','.') }}</th>
<th></th>
</tr>
</tfoot>

</table>

</div>

</div>

</div>
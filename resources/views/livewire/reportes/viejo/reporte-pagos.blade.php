<div>

<div class="card">

<div class="card-header">
<b>Reporte de Pagos</b>
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
<th>Método de pago</th>
<th>Total</th>
</tr>

</thead>

<tbody>

@foreach($pagos as $pago)

<tr>

<td>{{ ucfirst($pago->metodo_pago) }}</td>

<td>
Gs. {{ number_format($pago->total,0,',','.') }}
</td>

</tr>

@endforeach

</tbody>

<tfoot>

<tr>

<th>Total general</th>

<th>
Gs. {{ number_format($totalGeneral,0,',','.') }}
</th>

</tr>

</tfoot>

</table>

</div>

</div>

</div>
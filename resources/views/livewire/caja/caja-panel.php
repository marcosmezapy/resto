<div>

<div class="row mb-3">

<div class="col-md-3">

<select wire:model="tipo" class="form-control">

<option value="gasto">Gasto</option>
<option value="retiro">Retiro</option>
<option value="ingreso">Ingreso</option>

</select>

</div>

<div class="col-md-4">

<input
type="text"
class="form-control"
placeholder="Descripción"
wire:model="descripcion">

</div>

<div class="col-md-3">

<input
type="number"
class="form-control"
placeholder="Monto"
wire:model="monto">

</div>

<div class="col-md-2">

<button
wire:click="registrarMovimiento"
class="btn btn-primary w-100">

Registrar

</button>

</div>

</div>

<hr>

<table class="table table-sm">

<thead>

<tr>
<th>Tipo</th>
<th>Descripción</th>
<th>Monto</th>
</tr>

</thead>

<tbody>

@foreach($movimientos as $mov)

<tr>

<td>{{ strtoupper($mov->tipo) }}</td>

<td>{{ $mov->descripcion }}</td>

<td>{{ number_format($mov->monto,0,',','.') }}</td>

</tr>

@endforeach

</tbody>

</table>

</div>
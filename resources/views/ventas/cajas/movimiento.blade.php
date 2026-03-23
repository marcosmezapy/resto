@extends('adminlte::page')

@section('title','Movimiento de Caja')

@section('content')

<div class="card">

<div class="card-header">
Registrar Movimiento de Caja
</div>

<div class="card-body">

<form method="POST" action="{{ route('ventas.cajas.movimiento.store') }}">
@csrf

<div class="form-group">
<label>Tipo</label>

<select name="tipo" class="form-control">

<option value="gasto">Gasto</option>
<option value="retiro">Retiro</option>
<option value="ingreso">Ingreso</option>

</select>

</div>

<div class="form-group">

<label>Descripción</label>

<input
type="text"
name="descripcion"
class="form-control"
required>

</div>

<div class="form-group">

<label>Monto</label>

<input
type="number"
name="monto"
class="form-control"
required>

</div>

<br>

<button class="btn btn-success">

Guardar Movimiento

</button>

</form>

</div>

</div>

@endsection
@section('footer')
    @include('adminlte::partials.footer.footer')
@endsection

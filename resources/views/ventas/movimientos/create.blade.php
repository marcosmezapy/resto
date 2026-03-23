@extends('adminlte::page')

@section('title','Movimiento de Caja')

@section('content')

<div class="card">

<div class="card-body">

<form method="POST" action="{{ route('ventas.movimientos.store') }}">

@csrf

<div class="form-group">

<label>Tipo</label>

<select name="tipo" class="form-control">

<option value="ingreso">Ingreso</option>
<option value="retiro">Retiro</option>
<option value="gasto">Gasto</option>
<option value="ajuste">Ajuste</option>

</select>

</div>

<div class="form-group">

<label>Monto</label>

<input type="number" name="monto" step="0.01" class="form-control">

</div>

<div class="form-group">

<label>Descripcion</label>

<textarea name="descripcion" class="form-control"></textarea>

</div>

<br>

<button class="btn btn-success">

Registrar movimiento

</button>

</form>

</div>

</div>

@stop
@section('footer')
    @include('adminlte::partials.footer.footer')
@endsection

@extends('adminlte::page')

@section('title','Crear Cliente')

@section('content')

<div class="card">

<div class="card-body">

<form method="POST" action="{{ route('clientes.clientes.store') }}">

@csrf

<div class="form-group">
<label>Nombre</label>
<input type="text" name="nombre" class="form-control">
</div>

<div class="form-group">
<label>RUC</label>
<input type="text" name="ruc" class="form-control">
</div>

<div class="form-group">
<label>Telefono</label>
<input type="text" name="telefono" class="form-control">
</div>

<div class="form-group">
<label>Email</label>
<input type="email" name="email" class="form-control">
</div>

<div class="form-group">
<label>Direccion</label>
<input type="text" name="direccion" class="form-control">
</div>

<button class="btn btn-success">
Guardar
</button>

</form>

</div>

</div>

@stop
@section('footer')
    @include('adminlte::partials.footer.footer')
@endsection

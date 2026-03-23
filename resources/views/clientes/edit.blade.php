@extends('adminlte::page')

@section('title','Editar Cliente')

@section('content')

<div class="card">

<div class="card-body">

<form method="POST" action="{{ route('clientes.clientes.update',$cliente) }}">

@csrf
@method('PUT')

<div class="form-group">
<label>Nombre</label>
<input type="text" name="nombre" class="form-control" value="{{ $cliente->nombre }}">
</div>

<div class="form-group">
<label>RUC</label>
<input type="text" name="ruc" class="form-control" value="{{ $cliente->ruc }}">
</div>

<div class="form-group">
<label>Telefono</label>
<input type="text" name="telefono" class="form-control" value="{{ $cliente->telefono }}">
</div>

<div class="form-group">
<label>Email</label>
<input type="email" name="email" class="form-control" value="{{ $cliente->email }}">
</div>

<div class="form-group">
<label>Direccion</label>
<input type="text" name="direccion" class="form-control" value="{{ $cliente->direccion }}">
</div>

<button class="btn btn-success">
Actualizar
</button>

</form>

</div>

</div>

@stop
@section('footer')
    @include('adminlte::partials.footer.footer')
@endsection

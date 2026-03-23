@extends('adminlte::page')

@section('title','Crear Mesa')

@section('content')

<div class="card">

<div class="card-body">

<form method="POST" action="{{ route('mesas.mesas.store') }}">

@csrf

<div class="form-group">

<label>Numero de mesa</label>

<input type="text" name="numero" class="form-control">

</div>

<div class="form-group">

<label>Capacidad</label>

<input type="number" name="capacidad" class="form-control" value="4">

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

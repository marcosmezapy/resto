@extends('adminlte::page')

@section('title','Editar Mesa')

@section('content')

<div class="card">

<div class="card-body">

<form method="POST" action="{{ route('mesas.mesas.update',$mesa) }}">

@csrf
@method('PUT')

<div class="form-group">

<label>Numero de mesa</label>

<input type="text" name="numero" class="form-control" value="{{ $mesa->numero }}">

</div>

<div class="form-group">

<label>Capacidad</label>

<input type="number" name="capacidad" class="form-control" value="{{ $mesa->capacidad }}">

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

@extends('adminlte::page')

@section('title','Crear Caja')

@section('content')

<div class="card">

<div class="card-body">

<form method="POST" action="{{ route('ventas.cajas.store') }}">

@csrf

<div class="form-group">

<label>Nombre</label>

<input type="text" name="nombre" class="form-control">

</div>

<div class="form-group">

<label>Descripcion</label>

<textarea name="descripcion" class="form-control"></textarea>

</div>

<div class="form-group form-check mt-3">

<input type="checkbox" name="activa" class="form-check-input" checked>

<label class="form-check-label">
Activa
</label>

</div>

<br>

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

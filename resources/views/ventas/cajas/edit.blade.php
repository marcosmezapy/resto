@extends('adminlte::page')

@section('title','Editar Caja')

@section('content')

<div class="card">

<div class="card-body">

<form method="POST" action="{{ route('ventas.cajas.update',$caja) }}">

@csrf
@method('PUT')

<div class="form-group">

<label>Nombre</label>

<input type="text" name="nombre" class="form-control" value="{{ $caja->nombre }}">

</div>

<div class="form-group">

<label>Descripcion</label>

<textarea name="descripcion" class="form-control">{{ $caja->descripcion }}</textarea>

</div>

<div class="form-check mt-3">

<input type="checkbox" name="activa" class="form-check-input"
{{ $caja->activa ? 'checked' : '' }}>

<label class="form-check-label">
Activa
</label>

</div>

<br>

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

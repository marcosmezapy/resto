@extends('adminlte::page')

@section('title', 'Crear Módulo')

@section('content_header')
<h1>Crear Módulo</h1>
@stop

@section('content')
<div class="card">
    <div class="card-body">
        <form action="{{ route('administrador.modulos.store') }}" method="POST">
            @csrf

            <div class="form-group mb-3">
                <label for="name">Nombre del Módulo</label>
                <input type="text" name="name" id="name" class="form-control" value="{{ old('name') }}" required>
            </div>

            <div class="form-check mb-3">
                <input class="form-check-input" type="checkbox" name="active" id="active" checked>
                <label class="form-check-label" for="active">Activo</label>
            </div>

            <button type="submit" class="btn btn-primary">Crear Módulo</button>
        </form>
    </div>
</div>
@stop
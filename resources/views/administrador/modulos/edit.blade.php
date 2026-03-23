{{-- @extends('adminlte::page')

@section('title', 'Editar Módulo')

@section('content_header')
<h1>Editar Módulo</h1>
@stop

@section('content')
<div class="card">
    <div class="card-body">
        <form action="{{ route('administrador.modulos.update', $module->id) }}" method="POST">
            @csrf
            @method('PUT')

            <div class="form-group mb-3">
                <label for="name">Nombre del Módulo</label>
                <input type="text" name="name" id="name" class="form-control" value="{{ old('name', $module->name) }}" required>
            </div>

            <div class="form-check mb-3">
                <input class="form-check-input" type="checkbox" name="active" id="active" {{ $module->active ? 'checked' : '' }}>
                <label class="form-check-label" for="active">Activo</label>
            </div>

            <button type="submit" class="btn btn-success">Actualizar Módulo</button>
        </form>
    </div>
</div>
@stop
 --}}

@extends('adminlte::page')

@section('title', 'Editar Módulo')

@section('content_header')
<h1>Editar Módulo: {{ $module->name }}</h1>
@stop

@section('content')

@if(session('success'))
    <div class="alert alert-success">{{ session('success') }}</div>
@endif

{{-- Formulario de edición de módulo --}}
<form action="{{ route('administrador.modulos.update', $module) }}" method="POST">
    @csrf
    @method('PUT')

    <div class="form-group">
        <label>Nombre del módulo</label>
        <input type="text" name="name" class="form-control" value="{{ $module->name }}" required>
    </div>

    <div class="form-group form-check">
        <input type="checkbox" name="active" class="form-check-input" {{ $module->active ? 'checked' : '' }}>
        <label class="form-check-label">Activo</label>
    </div>

    <button type="submit" class="btn btn-primary">Actualizar módulo</button>
</form>

<hr>

<h3>Submódulos</h3>

{{-- Crear submódulo --}}
@can('administrador.modulos.create')
<form action="{{ route('administrador.modulos.submodules.store', $module) }}" method="POST">
    @csrf
    <div class="input-group mb-3">
        <input type="text" name="name" class="form-control" placeholder="Nombre submódulo" required>
        <div class="input-group-append">
            <button class="btn btn-success" type="submit">Agregar submódulo</button>
        </div>
    </div>
</form>
@endcan

{{-- Tabla de submódulos --}}
<table class="table table-bordered">
    <thead>
        <tr>
            <th>Nombre</th>
            <th>Activo</th>
            <th>Acciones</th>
        </tr>
    </thead>
    <tbody>
        @foreach($module->submodules as $submodule)
        <tr>
            <td>{{ $submodule->name }}</td>
            <td>{{ $submodule->active ? 'Sí' : 'No' }}</td>
            <td>
                @can('administrador.modulos.edit')
                <form action="{{ route('administrador.modulos.submodules.update', $submodule) }}" method="POST" style="display:inline-block;">
                    @csrf
                    @method('PUT')
                    <input type="text" name="name" value="{{ $submodule->name }}" class="form-control mb-1" style="display:inline-block; width:auto;">
                    <input type="checkbox" name="active" {{ $submodule->active ? 'checked' : '' }}>
                    <button type="submit" class="btn btn-sm btn-primary">Actualizar</button>
                </form>
                @endcan

                @can('administrador.modulos.delete')
                <form action="{{ route('administrador.modulos.submodules.delete', $submodule) }}" method="POST" style="display:inline-block;">
                    @csrf
                    @method('DELETE')
                    <button type="submit" class="btn btn-sm btn-danger" onclick="return confirm('¿Eliminar submódulo?')">Eliminar</button>
                </form>
                @endcan
            </td>
        </tr>
        @endforeach
    </tbody>
</table>

@stop
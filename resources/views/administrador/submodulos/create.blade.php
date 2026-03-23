@extends('adminlte::page')

@section('title', 'Crear Submódulo')

@section('content_header')
<h1>Crear Submódulo</h1>
@stop

@section('content')
<div class="card">
    <div class="card-body">
        <form action="{{ route('submodulos.store') }}" method="POST">
            @csrf

            <div class="form-group mb-3">
                <label for="name">Nombre del Submódulo</label>
                <input type="text" name="name" id="name" class="form-control" value="{{ old('name') }}" required>
            </div>

            <div class="form-group mb-3">
                <label for="module_id">Módulo Padre</label>
                <select name="module_id" id="module_id" class="form-control" required>
                    @foreach($modules as $module)
                        <option value="{{ $module->id }}">{{ $module->name }}</option>
                    @endforeach
                </select>
            </div>

            <div class="form-check mb-3">
                <input class="form-check-input" type="checkbox" name="active" id="active" checked>
                <label class="form-check-label" for="active">Activo</label>
            </div>

            <button type="submit" class="btn btn-primary">Crear Submódulo</button>
        </form>
    </div>
</div>
@stop
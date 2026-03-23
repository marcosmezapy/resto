@extends('adminlte::page')

@section('title', 'Módulos')

@section('content_header')
<h1>Módulos</h1>
@stop

@section('content')
<div class="mb-3">
    <a href="{{ route('administrador.modulos.create') }}" class="btn btn-primary">Crear Módulo</a>
</div>

<div class="card">
    <div class="card-body">
        @if(session('success'))
            <div class="alert alert-success">{{ session('success') }}</div>
        @endif

        <table class="table table-bordered table-hover">
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Nombre</th>
                    <th>Activo</th>
                    <th>Submódulos</th>
                    <th>Acciones</th>
                </tr>
            </thead>
            <tbody>
                @foreach($modules as $module)
                    <tr>
                        <td>{{ $module->id }}</td>
                        <td>{{ $module->name }}</td>
                        <td>
                            @if($module->active)
                                <span class="badge bg-success">Sí</span>
                            @else
                                <span class="badge bg-danger">No</span>
                            @endif
                        </td>
                        <td>
                            @foreach($module->submodules as $sub)
                                <span class="badge bg-info">{{ $sub->name }}</span>
                            @endforeach
                        </td>
                        <td>
                            <a href="{{ route('administrador.modulos.edit', $module->id) }}" class="btn btn-sm btn-warning">Editar</a>
                            <form action="{{ route('administrador.modulos.delete', $module->id) }}" method="POST" style="display:inline-block;" onsubmit="return confirm('¿Eliminar módulo?');">
                                @csrf
                                @method('DELETE')
                                <button class="btn btn-sm btn-danger">Eliminar</button>
                            </form>
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>
</div>
@stop
@extends('adminlte::page')

@section('title', 'Submódulos')

@section('content_header')
<h1>Submódulos</h1>
@stop

@section('content')
<div class="mb-3">
    <a href="{{ route('submodulos.create') }}" class="btn btn-primary">Crear Submódulo</a>
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
                    <th>Módulo Padre</th>
                    <th>Activo</th>
                    <th>Acciones</th>
                </tr>
            </thead>
            <tbody>
                @foreach($submodules as $sub)
                    <tr>
                        <td>{{ $sub->id }}</td>
                        <td>{{ $sub->name }}</td>
                        <td>{{ $sub->module->name }}</td>
                        <td>
                            @if($sub->active)
                                <span class="badge bg-success">Sí</span>
                            @else
                                <span class="badge bg-danger">No</span>
                            @endif
                        </td>
                        <td>
                            <a href="{{ route('submodulos.edit', $sub->id) }}" class="btn btn-sm btn-warning">Editar</a>
                            <form action="{{ route('submodulos.delete', $sub->id) }}" method="POST" style="display:inline-block;" onsubmit="return confirm('¿Eliminar submódulo?');">
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
@extends('adminlte::page')

@section('title', 'Editar Usuario')

@section('content_header')
<h1>Editar Usuario</h1>
@stop

@section('content')
<div class="card">
    <div class="card-body">
        <form action="{{ route('administrador.usuarios.update', $user->id) }}" method="POST">
            @csrf
            @method('PUT')

            <div class="form-group mb-3">
                <label for="name">Nombre</label>
                <input type="text" name="name" id="name" class="form-control" value="{{ old('name', $user->name) }}">
            </div>

            <div class="form-group mb-3">
                <label for="email">Email</label>
                <input type="email" name="email" id="email" class="form-control" value="{{ old('email', $user->email) }}">
            </div>

            <div class="form-group mb-3">
                <label for="password">Contraseña <small>(dejar en blanco para no cambiar)</small></label>
                <input type="password" name="password" id="password" class="form-control">
            </div>

            <div class="form-group mb-3">
                <label>Roles</label>
                <div class="form-check">
                    @foreach($roles as $role)
                        <input class="form-check-input" type="checkbox" name="roles[]" value="{{ $role->id }}" id="role_{{ $role->id }}"
                            {{ $user->roles->contains('id', $role->id) ? 'checked' : '' }}>
                        <label class="form-check-label" for="role_{{ $role->id }}">
                            {{ $role->name }}
                        </label><br>
                    @endforeach
                </div>
            </div>

            <button type="submit" class="btn btn-success">Actualizar Usuario</button>
        </form>
    </div>
</div>
@stop
@section('footer')
    @include('adminlte::partials.footer.footer')
@endsection

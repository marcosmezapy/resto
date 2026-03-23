@extends('adminlte::page')

@section('title', 'Crear Usuario')

@section('content_header')
<h1>Crear Usuario</h1>
@stop

@section('content')
<div class="card">
    <div class="card-body">
        <form action="{{ route('administrador.usuarios.store') }}" method="POST">
            @csrf

            {{-- Nombre --}}
            <div class="form-group mb-3">
                <label for="name">Nombre</label>
                <input type="text" name="name" id="name" class="form-control @error('name') is-invalid @enderror" 
                       value="{{ old('name') }}" placeholder="Nombre completo">
                @error('name')
                    <span class="invalid-feedback">{{ $message }}</span>
                @enderror
            </div>

            {{-- Email --}}
            <div class="form-group mb-3">
                <label for="email">Email</label>
                <input type="email" name="email" id="email" class="form-control @error('email') is-invalid @enderror" 
                       value="{{ old('email') }}" placeholder="usuario@ejemplo.com">
                @error('email')
                    <span class="invalid-feedback">{{ $message }}</span>
                @enderror
            </div>

            {{-- Contraseña --}}
            <div class="form-group mb-3">
                <label for="password">Contraseña</label>
                <input type="password" name="password" id="password" class="form-control @error('password') is-invalid @enderror">
                @error('password')
                    <span class="invalid-feedback">{{ $message }}</span>
                @enderror
            </div>

            {{-- Confirmar contraseña --}}
            <div class="form-group mb-3">
                <label for="password_confirmation">Confirmar Contraseña</label>
                <input type="password" name="password_confirmation" id="password_confirmation" class="form-control">
            </div>

            {{-- Roles (multibox con checkboxes) --}}
            <div class="form-group mb-3">
                <label>Roles</label>
                <div class="form-check">
                    @foreach($roles as $role)
                        <input class="form-check-input" type="checkbox" name="roles[]" value="{{ $role->id }}" 
                               id="role_{{ $role->id }}" {{ in_array($role->id, old('roles', [])) ? 'checked' : '' }}>
                        <label class="form-check-label" for="role_{{ $role->id }}">
                            {{ $role->name }}
                        </label><br>
                    @endforeach
                </div>
                @error('roles')
                    <span class="text-danger">{{ $message }}</span>
                @enderror
            </div>

            {{-- Botón enviar --}}
            <button type="submit" class="btn btn-primary">
                <i class="fas fa-user-plus"></i> Crear Usuario
            </button>
            <a href="{{ route('administrador.usuarios.view') }}" class="btn btn-secondary">
                Cancelar
            </a>
        </form>
    </div>
</div>
@stop
@section('footer')
    @include('adminlte::partials.footer.footer')
@endsection

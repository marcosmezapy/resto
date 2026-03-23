<div class="container-fluid">

    <!-- Mensaje de éxito -->
    @if (session()->has('message'))
        <div class="alert alert-success alert-dismissible fade show" role="alert">
            <i class="fas fa-check-circle"></i> {{ session('message') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    @endif

    <!-- Botón agregar depósito -->
    <div class="mb-3">
        <button wire:click="toggleForm" class="btn {{ $showForm ? 'btn-danger' : 'btn-success' }}">
            <i class="fas {{ $showForm ? 'fa-minus' : 'fa-plus' }}"></i>
            {{ $showForm ? 'Ocultar formulario' : 'Agregar depósito' }}
        </button>
    </div>

    <!-- Formulario -->
    @if($showForm)
        <div class="card card-primary mb-4 w-100">
            <div class="card-header">
                <h3 class="card-title">{{ $deposito_id ? 'Editar Depósito' : 'Agregar Depósito' }}</h3>
            </div>
            <div class="card-body">
                <form wire:submit.prevent="store">
                    <div class="mb-3">
                        <label>Nombre</label>
                        <input type="text" wire:model="nombre" class="form-control" placeholder="Nombre del depósito" required>
                    </div>
                    <div class="mb-3">
                        <label>Descripción</label>
                        <textarea wire:model="descripcion" class="form-control" placeholder="Descripción (opcional)"></textarea>
                    </div>
                    <button type="submit" class="btn btn-success">
                        <i class="fas fa-save"></i> {{ $deposito_id ? 'Actualizar' : 'Guardar' }}
                    </button>
                    <button type="button" wire:click="resetInputFields" class="btn btn-secondary">
                        <i class="fas fa-times"></i> Cancelar
                    </button>
                </form>
            </div>
        </div>
    @endif

    <!-- Tabla de depósitos -->
    <div class="table-responsive w-100">
        <table class="table table-bordered table-striped table-hover w-100">
            <thead class="table-dark">
                <tr>
                    <th>ID</th>
                    <th>Nombre</th>
                    <th>Descripción</th>
                    <th>Acciones</th>
                </tr>
            </thead>
            <tbody>
                @forelse($depositos as $dep)
                    <tr>
                        <td>{{ $dep->id }}</td>
                        <td>{{ $dep->nombre }}</td>
                        <td>{{ $dep->descripcion }}</td>
                        <td>
                            <button wire:click="edit({{ $dep->id }})" class="btn btn-primary btn-sm">
                                <i class="fas fa-edit"></i>
                            </button>
                            <button wire:click="delete({{ $dep->id }})" class="btn btn-danger btn-sm" onclick="confirm('¿Estás seguro de eliminar este depósito?') || event.stopImmediatePropagation()">
                                <i class="fas fa-trash"></i>
                            </button>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="4" class="text-center">No hay depósitos registrados.</td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>
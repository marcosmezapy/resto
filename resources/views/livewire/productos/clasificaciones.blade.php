<div>
    @if(session()->has('message'))
        <div class="alert alert-success">{{ session('message') }}</div>
    @endif

    <button class="btn btn-primary mb-3" wire:click="toggleForm">
        {{ $showForm ? 'Cancelar' : 'Agregar Clasificación' }}
    </button>

    @if($showForm)
    <div class="card card-info">
        <div class="card-body">
            <form wire:submit.prevent="store">
                <div class="form-group">
                    <label>Nombre</label>
                    <input type="text" wire:model="nombre" class="form-control" required>
                </div>
                <div class="form-group">
                    <label>Descripción</label>
                    <textarea wire:model="descripcion" class="form-control"></textarea>
                </div>
                <button type="submit" class="btn btn-success mt-2">
                    {{ $clasificacion_id ? 'Actualizar' : 'Guardar' }}
                </button>
            </form>
        </div>
    </div>
    @endif

    <div class="card">
        <div class="card-body">
            <table class="table table-bordered table-hover">
                <thead>
                    <tr>
                        <th>Nombre</th>
                        <th>Descripción</th>
                        <th>Acciones</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($clasificaciones as $c)
                    <tr>
                        <td>{{ $c->nombre }}</td>
                        <td>{{ $c->descripcion }}</td>
                        <td>
                            <button wire:click="edit({{ $c->id }})" class="btn btn-sm btn-primary">Editar</button>
                            <button wire:click="delete({{ $c->id }})" class="btn btn-sm btn-danger" onclick="confirm('¿Seguro que quieres eliminar?') || event.stopImmediatePropagation()">Eliminar</button>
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
</div>
<div>
    <div class="mb-3">
        <input type="text" wire:model="search" class="form-control" placeholder="Buscar usuario...">
    </div>

    <table class="table table-bordered table-striped">
        <thead class="table-dark">
            <tr>
                <th>ID</th>
                <th>Nombre</th>
                <th>Email</th>
                <th>Roles</th>
                <th>Acciones</th>
            </tr>
        </thead>
        <tbody>
            @forelse($users as $user)
                <tr>
                    <td>{{ $user->id }}</td>
                    <td>{{ $user->name }}</td>
                    <td>{{ $user->email }}</td>
                    <td>{{ implode(', ', $user->getRoleNames()->toArray()) }}</td>
                    <td>
                        @can('administrador.usuarios.edit')
                            <a href="{{ route('administrador.usuarios.edit', $user) }}" class="btn btn-sm btn-primary">Editar</a>
                        @endcan
                        @can('administrador.usuarios.delete')
                            <form action="{{ route('administrador.usuarios.destroy', $user) }}" method="POST" class="d-inline">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn btn-sm btn-danger" 
                                    onclick="return confirm('¿Seguro que deseas eliminar este usuario?')">Eliminar</button>
                            </form>
                        @endcan
                    </td>
                </tr>
            @empty
                <tr>
                    <td colspan="5" class="text-center">No hay usuarios registrados.</td>
                </tr>
            @endforelse
        </tbody>
    </table>

    <div>
        {{ $users->links() }}
    </div>
</div>
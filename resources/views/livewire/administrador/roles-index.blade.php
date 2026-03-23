<div class="card">

    <div class="card-header">

        <div class="row">

            <div class="col-md-6">

                <input
                    type="text"
                    class="form-control"
                    placeholder="Buscar rol..."
                    wire:model.live="search">

            </div>

            <div class="col-md-6 text-right">

                <button
                    class="btn btn-primary"
                    wire:click="$dispatch('openRoleForm')">

                    <i class="fas fa-plus"></i>
                    Nuevo

                </button>

            </div>

        </div>

    </div>


    <div class="card-body p-0">

        <table class="table table-hover">

            <thead>

                <tr>

                    <th>ID</th>
                    <th>Rol</th>
                    <th width="120">Acciones</th>

                </tr>

            </thead>

            <tbody>

                @foreach($roles as $role)

                <tr>

                    <td>{{ $role->id }}</td>

                    <td>{{ $role->name }}</td>

                    <td>

                        <button
                            class="btn btn-sm btn-warning"
                            wire:click="$dispatch('editRole', { id: {{ $role->id }} })">

                            <i class="fas fa-edit"></i>

                        </button>

                        <button
                            class="btn btn-sm btn-danger"
                            wire:click="delete({{ $role->id }})">

                            <i class="fas fa-trash"></i>

                        </button>

                    </td>

                </tr>

                @endforeach

            </tbody>

        </table>

    </div>

    <div class="card-footer">

        {{ $roles->links() }}

    </div>

</div>
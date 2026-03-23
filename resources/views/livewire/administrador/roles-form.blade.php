<div class="card card-success">

    <div class="card-header">

        <h3 class="card-title">

            {{ $roleId ? 'Editar Rol' : 'Crear Rol' }}

        </h3>

    </div>


    <div class="card-body">

        <div class="form-group">

            <label>Nombre del Rol</label>

            <input
                type="text"
                class="form-control"
                wire:model="name"
                placeholder="Ej: Administrador">

        </div>


        <div class="form-group">

            <label>Permisos</label>

            <div class="form-check mb-2">

                <input
                    type="checkbox"
                    class="form-check-input"
                    wire:model="selectAll">

                <label class="form-check-label">

                    Seleccionar todos

                </label>

            </div>


            <div style="max-height:300px; overflow:auto; border:1px solid #ddd; padding:10px;">

                @foreach($permissions as $permission)

                <div class="form-check">

                    <input
                        type="checkbox"
                        class="form-check-input"
                        value="{{ $permission->name }}"
                        wire:model="selectedPermissions">

                    <label class="form-check-label">

                        {{ $permission->name }}

                    </label>

                </div>

                @endforeach

            </div>

        </div>

    </div>


    <div class="card-footer text-right">

        @if($roleId)

        <button
            class="btn btn-secondary"
            wire:click="create">

            Cancelar

        </button>

        @endif

        <button
            class="btn btn-success"
            wire:click="save">

            <i class="fas fa-save"></i>

            Guardar

        </button>

    </div>

</div>
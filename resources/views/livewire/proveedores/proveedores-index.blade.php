<div>

    <div class="card card-outline card-primary">

        {{-- HEADER --}}
        <div class="card-header d-flex justify-content-between align-items-center">
            <h3 class="card-title">
                <i class="fas fa-truck"></i> Proveedores
            </h3>

            <button wire:click="nuevo" class="btn btn-success btn-sm">
                <i class="fas fa-plus"></i> Nuevo Proveedor
            </button>
        </div>

        <div class="card-body">

            {{-- LOADING --}}
            <div wire:loading class="text-center mb-2">
                <i class="fas fa-spinner fa-spin"></i> Procesando...
            </div>

            {{-- FORM OCULTO --}}
            @if($mostrarForm)
                <div class="card card-secondary mb-3">
                    <div class="card-header">
                        <strong>
                            {{ $modoEdicion ? 'Editar Proveedor' : 'Nuevo Proveedor' }}
                        </strong>
                    </div>

                    <div class="card-body">

                        <div class="row">

                            <div class="col-md-3">
                                <input type="text" wire:model="nombre" class="form-control" placeholder="Nombre">
                            </div>

                            <div class="col-md-2">
                                <input type="text" wire:model="ruc" class="form-control" placeholder="RUC">
                            </div>

                            <div class="col-md-2">
                                <input type="text" wire:model="telefono" class="form-control" placeholder="Teléfono">
                            </div>

                            <div class="col-md-2">
                                <input type="email" wire:model="email" class="form-control" placeholder="Email">
                            </div>

                            <div class="col-md-3">
                                <input type="text" wire:model="direccion" class="form-control" placeholder="Dirección">
                            </div>

                        </div>

                        <div class="mt-3">

                            @if($modoEdicion)
                                <button wire:click="actualizar" class="btn btn-primary">
                                    <i class="fas fa-save"></i> Actualizar
                                </button>
                            @else
                                <button wire:click="guardar" class="btn btn-success">
                                    <i class="fas fa-save"></i> Guardar
                                </button>
                            @endif

                            <button wire:click="cancelar" class="btn btn-secondary">
                                Cancelar
                            </button>

                        </div>

                    </div>
                </div>
            @endif

            {{-- TABLA --}}
            <div class="table-responsive">
                <table class="table table-bordered table-hover table-sm">

                    <thead class="thead-dark">
                        <tr>
                            <th>Nombre</th>
                            <th>RUC</th>
                            <th>Teléfono</th>
                            <th>Email</th>
                            <th width="120">Acciones</th>
                        </tr>
                    </thead>

                    <tbody>
                        @forelse($proveedores as $p)
                            <tr>
                                <td>{{ $p->nombre }}</td>
                                <td>{{ $p->ruc }}</td>
                                <td>{{ $p->telefono }}</td>
                                <td>{{ $p->email }}</td>
                                <td>

                                    <button wire:click="editar({{ $p->id }})"
                                        class="btn btn-xs btn-warning">
                                        <i class="fas fa-edit"></i>
                                    </button>

                                    <button wire:click="eliminar({{ $p->id }})"
                                        class="btn btn-xs btn-danger">
                                        <i class="fas fa-trash"></i>
                                    </button>

                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="5" class="text-center">
                                    No hay proveedores registrados
                                </td>
                            </tr>
                        @endforelse
                    </tbody>

                </table>
            </div>

        </div>
    </div>

</div>
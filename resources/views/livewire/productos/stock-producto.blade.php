<div class="container-fluid">

    <!-- Mensaje de éxito -->
    @if (session()->has('message'))
        <div class="alert alert-success alert-dismissible fade show" role="alert">
            <i class="fas fa-check-circle"></i> {{ session('message') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    @endif

    <!-- Botón para mostrar/ocultar formulario -->
    <div class="mb-3">
        <button wire:click="toggleForm" class="btn {{ $showForm ? 'btn-danger' : 'btn-success' }}">
            <i class="fas {{ $showForm ? 'fa-minus' : 'fa-plus' }}"></i>
            {{ $showForm ? 'Ocultar formulario' : 'Agregar stock' }}
        </button>
    </div>

    <!-- Formulario de stock -->
    @if($showForm)
        <div class="card card-primary mb-4 w-100">
            <div class="card-header">
                <h3 class="card-title">Agregar Stock para: <strong>{{ $producto->nombre }}</strong></h3>
            </div>
            <div class="card-body">
                <form wire:submit.prevent="addStock">
                    <div class="row mb-3">
                        <div class="col-md-6">
                            <label>Depósito</label>
                            <select wire:model="deposito_id" class="form-control" required>
                                <option value="">Selecciona depósito</option>
                                @foreach($depositos as $d)
                                    <option value="{{ $d->id }}">{{ $d->nombre }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="col-md-6">
                            <label>Lote</label>
                            <input type="text" wire:model="lote" class="form-control" placeholder="Lote" required>
                        </div>
                    </div>

                    <div class="row mb-3">
                        <div class="col-md-4">
                            <label>Fecha de ingreso</label>
                            <input type="date" wire:model="fecha_ingreso" class="form-control" required>
                        </div>
                        <div class="col-md-4">
                            <label>Cantidad</label>
                            <input type="number" wire:model="cantidad" class="form-control" min="1" required>
                        </div>
                        <div class="col-md-4">
                            <label>Costo compra</label>
                            <input type="number" wire:model="costo_compra" class="form-control" min="0" required>
                        </div>
                        <div class="col-md-6">
                            <label>Proveedor</label>
                            <select wire:model="proveedor_id" class="form-control">
                                <option value="">Selecciona proveedor</option>
                                @foreach($proveedores as $prov)
                                    <option value="{{ $prov->id }}">{{ $prov->nombre }}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>

                    <button type="submit" class="btn btn-success">
                        <i class="fas fa-save"></i> Guardar
                    </button>

                    <button type="button" wire:click="resetInputFields" class="btn btn-secondary">
                        <i class="fas fa-times"></i> Cancelar
                    </button>
                </form>
            </div>
        </div>
    @endif

    <!-- Tabla de stock -->
    <div class="table-responsive w-100">
        <table class="table table-bordered table-striped table-hover w-100">
            <thead class="table-dark">
                <tr>
                    <th>Depósito</th>
                    <th>Lote</th>
                    <th>Fecha ingreso</th>
                    <th>Cantidad</th>
                    <th>Costo compra</th>
                    <th>Proveedor</th>
                </tr>
            </thead>
            <tbody>
                @forelse($stocks as $stock)
                    <tr>
                        <td>{{ $stock->deposito->nombre }}</td>
                        <td>{{ $stock->lote }}</td>
                        <td>{{ $stock->fecha_ingreso }}</td>
                        <td>{{ $stock->cantidad }}</td>
                        <td>{{ number_format($stock->costo_compra,0,',','.') }}</td>
                        <td>{{ $stock->proveedor->nombre ?? '-' }}</td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="6" class="text-center">No hay stock registrado.</td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>

</div>
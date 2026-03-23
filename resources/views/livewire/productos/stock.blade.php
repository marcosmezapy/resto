<div>
    @if(session()->has('message'))
        <div class="alert alert-success">{{ session('message') }}</div>
    @endif

    <button class="btn btn-primary mb-3" wire:click="toggleForm">
        {{ $showForm ? 'Cancelar' : 'Agregar Stock' }}
    </button>

    @if($showForm)
    <div class="card card-info">
        <div class="card-body">
            <form wire:submit.prevent="store">
                <div class="form-row">
                    <div class="form-group col-md-4">
                        <label>Producto</label>
                        <select wire:model="producto_id" class="form-control" required>
                            <option value="">Seleccione producto</option>
                            @foreach($productos as $p)
                                <option value="{{ $p->id }}">{{ $p->nombre }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="form-group col-md-4">
                        <label>Depósito</label>
                        <select wire:model="deposito_id" class="form-control" required>
                            <option value="">Seleccione depósito</option>
                            @foreach($depositos as $d)
                                <option value="{{ $d->id }}">{{ $d->nombre }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="form-group col-md-4">
                        <label>Lote</label>
                        <input type="text" wire:model="lote" class="form-control" required>
                    </div>
                </div>

                <div class="form-row">
                    <div class="form-group col-md-3">
                        <label>Fecha Ingreso</label>
                        <input type="date" wire:model="fecha_ingreso" class="form-control" required>
                    </div>
                    <div class="form-group col-md-3">
                        <label>Cantidad</label>
                        <input type="number" wire:model="cantidad" class="form-control" min="1" required>
                    </div>
                    <div class="form-group col-md-3">
                        <label>Costo Compra</label>
                        <input type="number" wire:model="costo_compra" class="form-control" min="0" required>
                    </div>
                    <div class="form-group col-md-4">
                        <label>Proveedor</label>
                        <select wire:model="proveedor_id" class="form-control">
                            <option value="">Seleccione proveedor</option>
                            @foreach($proveedores as $prov)
                                <option value="{{ $prov->id }}">{{ $prov->nombre }}</option>
                            @endforeach
                        </select>
                    </div>
                </div>

                <button type="submit" class="btn btn-success">
                    {{ $stock_id ? 'Actualizar' : 'Guardar' }}
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
                        <th>Producto</th>
                        <th>Depósito</th>
                        <th>Lote</th>
                        <th>Fecha Ingreso</th>
                        <th>Cantidad</th>
                        <th>Costo Compra</th>
                        <th>Proveedor</th>
                        <th>Acciones</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($stocks as $s)
                    <tr>
                        <td>{{ $s->producto->nombre }}</td>
                        <td>{{ $s->deposito->nombre }}</td>
                        <td>{{ $s->lote }}</td>
                        <td>{{ $s->fecha_ingreso }}</td>
                        <td>{{ $s->cantidad }}</td>
                        <td>{{ number_format($s->costo_compra, 0, ',', '.') }}</td>
                        <td>{{ $s->proveedor->nombre ?? '-' }}</td>
                        <td>
                            <button wire:click="edit({{ $s->id }})" class="btn btn-sm btn-primary">Editar</button>
                            <button wire:click="delete({{ $s->id }})" class="btn btn-sm btn-danger" onclick="confirm('¿Seguro que quieres eliminar?') || event.stopImmediatePropagation()">Eliminar</button>
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
</div>
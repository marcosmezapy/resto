<div>
    @if(count($items))
    <div class="card mt-3">

        <div class="card-header bg-primary text-white">
            Nueva Compra
        </div>

        <div class="card-body">

            <div class="row mb-3">

                <!-- PROVEEDOR -->
                <div class="col-md-3">
                    <label>Proveedor *</label>
                    <select wire:model="proveedor_id" class="form-control">
                        <option value="">Seleccionar</option>
                        @foreach($proveedores as $p)
                            <option value="{{ $p->id }}">{{ $p->nombre }}</option>
                        @endforeach
                    </select>
                    @error('proveedor_id')
                        <small class="text-danger">{{ $message }}</small>
                    @enderror
                </div>

                <!-- DEPÓSITO -->
                <div class="col-md-3">
                    <label>Depósito *</label>
                    <select wire:model="deposito_id" class="form-control">
                        <option value="">Seleccionar</option>
                        @foreach($depositos as $d)
                            <option value="{{ $d->id }}">{{ $d->nombre }}</option>
                        @endforeach
                    </select>
                    @error('deposito_id')
                        <small class="text-danger">{{ $message }}</small>
                    @enderror
                </div>

                <!-- FACTURA -->
                <div class="col-md-3">
                    <label>N° Factura</label>
                    <input type="text" wire:model="numero_factura" class="form-control">
                </div>

                <!-- FECHA -->
                <div class="col-md-3">
                    <label>Fecha *</label>
                    <input type="date" wire:model="fecha" class="form-control">
                </div>

            </div>

            <button wire:click="agregarItem" class="btn btn-success btn-sm mb-2">
                + Producto
            </button>

            <table class="table table-bordered">
                <thead>
                    <tr>
                        <th>Producto</th>
                        <th>Cantidad</th>
                        <th>Precio</th>
                        <th>Subtotal</th>
                        <th></th>
                    </tr>
                </thead>

                <tbody>
                    @foreach($items as $index => $item)
                    <tr>
                        <td>
                            <select wire:model="items.{{ $index }}.producto_id" class="form-control">
                                <option value="">Seleccionar</option>
                                @foreach($productos as $prod)
                                    <option value="{{ $prod->id }}">{{ $prod->nombre }}</option>
                                @endforeach
                            </select>
                        </td>

                        <td>
                            <input type="number" wire:model.live="items.{{ $index }}.cantidad" class="form-control">
                        </td>

                        <td>
                            <input type="number" wire:model.live="items.{{ $index }}.precio" class="form-control">
                        </td>

                        <td>
                            {{ number_format($item['subtotal'], 0, ',', '.') }}
                        </td>

                        <td>
                            <button wire:click="eliminarItem({{ $index }})" class="btn btn-danger btn-sm">
                                X
                            </button>
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>

            <h4 class="text-end">
                Total: {{ number_format($this->total, 0, ',', '.') }}
            </h4>

            <div class="text-end">
                <button wire:click="guardar" class="btn btn-primary">
                    Guardar
                </button>
            </div>

        </div>
    </div>
    @endif
</div>
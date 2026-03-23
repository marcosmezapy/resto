<div>
    <!-- HEADER -->
    <div class="d-flex justify-content-between align-items-center mb-3">
        <h4 class="mb-0">Compras de Productos Stockeables</h4>

        <button wire:click="$dispatch('crearCompra')" class="btn btn-primary">
            <i class="fas fa-plus"></i> Nueva Compra
        </button>
    </div>

    <!-- FORMULARIO -->
    <livewire:compras.compra-create />

    <!-- TABLA -->
    <div class="card mt-3">
        <div class="card-body p-0">

            <table class="table table-hover mb-0">
                <thead class="bg-light">
                    <tr>
                        <th>#</th>
                        <th>Proveedor</th>
                        <th>Factura</th>
                        <th>Fecha</th>
                        <th class="text-end">Total</th>
                        <th>Estado</th>
                    </tr>
                </thead>

                <tbody>
                    @forelse($compras as $compra)
                        <tr>
                            <td>{{ $compra->id }}</td>
                            <td>{{ $compra->proveedor->nombre ?? '-' }}</td>
                            <td>{{ $compra->numero_factura }}</td>
                            <td>{{ $compra->fecha }}</td>
                            <td class="text-end">
                                {{ number_format($compra->total, 0, ',', '.') }}
                            </td>
                            <td>
                                <span class="badge bg-success">
                                    {{ $compra->estado }}
                                </span>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="6" class="text-center py-3">
                                Sin registros
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>

        </div>
    </div>
</div>
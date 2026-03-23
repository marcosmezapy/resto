<div class="container-fluid bg-gray-50 py-4">

    {{-- ALERTA --}}
    @if (session()->has('message'))
        <div class="mb-4">
            <div class="alert alert-success d-flex align-items-center justify-content-between shadow-sm rounded">
                <div>
                    <i class="fas fa-check-circle me-2"></i> 
                    {{ session('message') }}
                </div>
                <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
            </div>
        </div>
    @endif

    {{-- HEADER --}}
    <div class="d-flex justify-content-between align-items-center mb-3">
        <h5 class="fw-semibold text-dark m-0">Gestión de Productos</h5>

        <button wire:click="toggleForm"
            class="btn {{ $showForm ? 'btn-outline-danger' : 'btn-dark' }} btn-sm shadow-sm px-3">
            <i class="fas {{ $showForm ? 'fa-minus' : 'fa-plus' }}"></i>
            {{ $showForm ? 'Ocultar' : 'Nuevo Producto' }}
        </button>
    </div>

    {{-- FORMULARIO --}}
    @if($showForm)
        <div class="card border-0 shadow-sm rounded-3 mb-3">
            <div class="card-header bg-white border-bottom py-2 px-3">
                <h6 class="mb-0 fw-semibold text-dark">
                    {{ $updateMode ? 'Editar Producto' : 'Nuevo Producto' }}
                </h6>
            </div>

            <div class="card-body py-3 px-3">
                <form wire:submit.prevent="store">

                    <div class="row g-2 mb-2">
                        <div class="col-md-6">
                            <label class="form-label small text-muted mb-1">Nombre</label>
                            <input type="text" wire:model="nombre"
                                class="form-control form-control-sm">
                        </div>

                        <div class="col-md-6">
                            <label class="form-label small text-muted mb-1">SKU</label>
                            <input type="text" wire:model="sku"
                                class="form-control form-control-sm">
                        </div>
                    </div>

                    <div class="mb-2">
                        <label class="form-label small text-muted mb-1">Descripción</label>
                        <textarea wire:model="descripcion"
                            class="form-control form-control-sm"
                            rows="1"></textarea>
                    </div>

                    <div class="row g-2 mb-2">
                        <div class="col-md-6">
                            <label class="form-label small text-muted mb-1">Clasificación</label>
                            <select wire:model="clasificacion_id"
                                class="form-control form-control-sm select2">
                                <option value="">Seleccionar</option>
                                @foreach($clasificaciones as $c)
                                    <option value="{{ $c->id }}">{{ $c->nombre }}</option>
                                @endforeach
                            </select>
                        </div>

                        <div class="col-md-6 d-flex align-items-end">
                            <div class="form-check">
                                <input type="checkbox"
                                    wire:model.live="es_stockeable"
                                    class="form-check-input"
                                    id="es_stockeable">
                                <label class="form-check-label small text-muted">
                                    Controlar stock
                                </label>
                            </div>
                        </div>
                    </div>

                    <div class="row g-2 mb-3">
                        <div class="col-md-4">
                            <label class="form-label small text-muted mb-1">IVA</label>
                            <select wire:model="iva_tipo_id"
                                class="form-control form-control-sm select2">
                                <option value="">Seleccionar</option>
                                @foreach($ivaTipos as $iva)
                                    <option value="{{ $iva->id }}">
                                        {{ $iva->nombre }} ({{ $iva->porcentaje }}%)
                                    </option>
                                @endforeach
                            </select>
                        </div>

                        @if(!$es_stockeable)
                        <div class="col-md-4">
                            <label class="form-label small text-muted mb-1">Costo</label>
                            <input type="number"
                                wire:model="costo_base"
                                class="form-control form-control-sm"
                                step="0.01">
                        </div>
                        @endif

                        <div class="col-md-4">
                            <label class="form-label small text-muted mb-1">Precio</label>
                            <input type="number"
                                wire:model="precio_venta"
                                class="form-control form-control-sm"
                                step="0.01">
                        </div>
                    </div>

                    <div class="d-flex gap-2">
                        <button type="submit" class="btn btn-dark btn-sm px-3">
                            <i class="fas fa-save me-1"></i>
                            {{ $updateMode ? 'Actualizar' : 'Guardar' }}
                        </button>

                        @if($updateMode)
                            <button type="button"
                                wire:click="resetInputFields"
                                class="btn btn-outline-secondary btn-sm">
                                Cancelar
                            </button>
                        @endif
                    </div>

                </form>
            </div>
        </div>
    @endif

    {{-- TABLA (NO TOCADA) --}}
    <div class="card border-0 shadow-sm rounded-3">
        <div class="card-body p-0">

            <div class="table-responsive">
                <table class="table align-middle mb-0">

                    <thead class="bg-light">
                        <tr class="text-muted small text-uppercase">
                            <th>Producto</th>
                            <th>SKU</th>
                            <th>Clasificación</th>
                            <th>Stock</th>
                            <th>IVA</th>
                            <th class="text-center">Acciones</th>
                        </tr>
                    </thead>

                    <tbody>
                        @forelse($productos as $producto)
                            <tr>
                                <td class="fw-semibold">{{ $producto->nombre }}</td>

                                <td class="text-muted">{{ $producto->sku }}</td>

                                <td>
                                    <span class="badge bg-light text-dark border">
                                        {{ $producto->clasificacion->nombre ?? '-' }}
                                    </span>
                                </td>

                                <td>
                                    @if($producto->es_stockeable)
                                        <span class="badge bg-dark">
                                            {{ $producto->stocks->sum('cantidad') }}
                                        </span>
                                    @else
                                        <span class="text-muted small">N/A</span>
                                    @endif
                                </td>

                                <td>
                                    @if($producto->ivaTipo)
                                        <span class="badge bg-success-subtle text-success border">
                                            {{ $producto->ivaTipo->nombre }}
                                        </span>
                                    @else
                                        <span class="text-muted small">Sin IVA</span>
                                    @endif
                                </td>

                                <td class="text-center">
                                    <div class="d-flex justify-content-center gap-2">

                                        <button wire:click="edit({{ $producto->id }})"
                                            class="btn btn-sm btn-outline-dark">
                                            <i class="fas fa-edit"></i>
                                            <span>Editar</span>
                                        </button>

                                        <button wire:click="delete({{ $producto->id }})"
                                            class="btn btn-sm btn-outline-danger"
                                            onclick="return confirm('¿Eliminar este producto?')">
                                            <i class="fas fa-trash"></i>
                                            <span>Eliminar</span>
                                        </button>

                                        @if($producto->es_stockeable)
                                            <a href="{{ route('productos.producto.stock.view', $producto->id) }}"
                                                class="btn btn-sm btn-outline-warning">
                                                <i class="fas fa-boxes"></i>
                                                <span>Stock</span>
                                            </a>
                                        @endif

                                    </div>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="6" class="text-center text-muted py-4">
                                    No hay productos registrados
                                </td>
                            </tr>
                        @endforelse
                    </tbody>

                </table>
            </div>

        </div>
    </div>

</div>

{{-- SCRIPT SELECT2 --}}
@push('scripts')
<script>
document.addEventListener('livewire:load', function () {

    function initSelect2() {
        $('.select2').select2({
            theme: 'bootstrap-5',
            width: '100%',
            placeholder: "Seleccionar"
        });

        $('.select2').on('change', function () {
            let data = $(this).val();
            let wireModel = $(this).attr('wire:model');
            @this.set(wireModel, data);
        });
    }

    initSelect2();

    Livewire.hook('message.processed', () => {
        initSelect2();
    });
});
</script>
@endpush
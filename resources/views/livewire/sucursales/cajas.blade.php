<div class="card card-outline card-secondary mt-4">

    <div class="card-header">
        <h3 class="card-title">Cajas (Administración)</h3>
    </div>

    <div class="card-body">

        {{-- FORM --}}
        <div class="row mb-3">

            {{-- Sucursal --}}
            <div class="col-md-3">
                <label class="mb-1">Sucursal</label>
                <select class="form-control form-control-sm" wire:model.live="sucursal_id">
                    <option value="">Seleccione</option>
                    @foreach($sucursales as $s)
                        <option value="{{ $s->id }}">
                            {{ $s->codigo }} - {{ $s->nombre }}
                        </option>
                    @endforeach
                </select>
            </div>

            {{-- Punto --}}
            <div class="col-md-3">
                <label class="mb-1">Punto Expedición</label>
                <select class="form-control form-control-sm" wire:model="punto_expedicion_id">
                    <option value="">Seleccione</option>
                    @foreach($puntos as $p)
                        <option value="{{ $p->id }}">
                            {{ $p->codigo }}
                        </option>
                    @endforeach
                </select>
            </div>

            {{-- Nombre --}}
            <div class="col-md-2">
                <label class="mb-1">Nombre</label>
                <input type="text"
                       class="form-control form-control-sm"
                       wire:model="nombre">
            </div>

            {{-- Estado --}}
            <div class="col-md-2">
                <label class="mb-1">Estado</label>
                <select class="form-control form-control-sm" wire:model="activa">
                    <option value="1">Activa</option>
                    <option value="0">Inactiva</option>
                </select>
            </div>

            {{-- Botón --}}
            <div class="col-md-2 d-flex align-items-end">
                <button class="btn btn-dark btn-sm w-100" wire:click="guardar">
                    {{ $editando ? 'Actualizar' : 'Guardar' }}
                </button>
            </div>

        </div>

        {{-- DESCRIPCIÓN --}}
        <div class="row mb-3">
            <div class="col-md-6">
                <input type="text"
                       class="form-control form-control-sm"
                       wire:model="descripcion"
                       placeholder="Descripción">
            </div>
        </div>

        <hr>

        {{-- TABLA --}}
        <table class="table table-sm table-bordered">
            <thead class="bg-light">
                <tr>
                    <th>Sucursal</th>
                    <th>Punto</th>
                    <th>Nombre</th>
                    <th>Descripción</th>
                    <th>Estado</th>
                    <th style="width:150px;"></th>
                </tr>
            </thead>

            <tbody>
                @foreach($cajas as $c)
                    <tr>

                        <td>
                            {{ $c->puntoExpedicion->sucursal->codigo ?? '' }}
                            -
                            {{ $c->puntoExpedicion->sucursal->nombre ?? '' }}
                        </td>

                        <td>
                            {{ $c->puntoExpedicion->codigo ?? '' }}
                        </td>

                        <td>{{ $c->nombre }}</td>

                        <td>{{ $c->descripcion }}</td>

                        <td>
                            @if($c->activa)
                                <span class="badge bg-success">Activa</span>
                            @else
                                <span class="badge bg-secondary">Inactiva</span>
                            @endif
                        </td>

                        <td>
                            <button class="btn btn-sm btn-outline-dark"
                                    wire:click="editar({{ $c->id }})">
                                Editar
                            </button>

                            <button class="btn btn-sm btn-outline-secondary"
                                    wire:click="toggle({{ $c->id }})">
                                Estado
                            </button>
                        </td>

                    </tr>
                @endforeach
            </tbody>
        </table>

    </div>
</div>
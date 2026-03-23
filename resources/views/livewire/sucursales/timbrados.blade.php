<div class="card card-outline card-secondary">
    <div class="card-header">
        <h3 class="card-title">Timbrados</h3>
    </div>

    <div class="card-body">

        {{-- 🔹 FILA 1 --}}
        <div class="row mb-2">

            {{-- 🔥 SUCURSAL --}}
            <div class="col-md-4">
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

            {{-- 🔥 PUNTO --}}
            <div class="col-md-4">
                <label class="mb-1">Punto de Expedición</label>
                <select class="form-control form-control-sm" wire:model="punto_expedicion_id">
                    <option value="">Seleccione</option>
                    @foreach($puntos as $p)
                        <option value="{{ $p->id }}">
                            {{ $p->codigo }}
                        </option>
                    @endforeach
                </select>
            </div>

            <div class="col-md-4">
                <label class="mb-1">N° Timbrado</label>
                <input type="text" class="form-control form-control-sm" wire:model="numero_timbrado">
            </div>

        </div>

        {{-- 🔹 FILA 2 --}}
        <div class="row mb-2">

            <div class="col-md-3">
                <label class="mb-1">Desde</label>
                <input type="number" class="form-control form-control-sm" wire:model="numero_inicio">
            </div>

            <div class="col-md-3">
                <label class="mb-1">Hasta</label>
                <input type="number" class="form-control form-control-sm" wire:model="numero_fin">
            </div>

            <div class="col-md-3">
                <label class="mb-1">Fecha Inicio</label>
                <input type="date" class="form-control form-control-sm" wire:model="fecha_inicio">
            </div>

            <div class="col-md-3">
                <label class="mb-1">Fecha Fin</label>
                <input type="date" class="form-control form-control-sm" wire:model="fecha_fin">
            </div>

        </div>

        {{-- 🔹 BOTÓN --}}
        <div class="row mb-3">
            <div class="col-md-2">
                <button class="btn btn-dark btn-sm w-100" wire:click="guardar">
                    Guardar
                </button>
            </div>
        </div>

        <hr>

        {{-- 🔹 TABLA --}}
        <table class="table table-sm table-bordered">
            <thead class="bg-light">
                <tr>
                    <th>Timbrado</th>
                    <th>Sucursal</th>
                    <th>Punto</th>
                    <th>Rango</th>
                    <th>Último</th>
                    <th>Vigencia</th>
                    <th>Estado</th>
                </tr>
            </thead>
            <tbody>
                @foreach($timbrados as $t)
                    <tr>
                        <td>{{ $t->numero_timbrado }}</td>

                        <td>
                            {{ $t->puntoExpedicion->sucursal->codigo ?? '' }}
                            -
                            {{ $t->puntoExpedicion->sucursal->nombre ?? '' }}
                        </td>

                        <td>{{ $t->puntoExpedicion->codigo ?? '' }}</td>

                        <td>{{ $t->numero_inicio }} - {{ $t->numero_fin }}</td>

                        <td>{{ $t->ultimo_numero_usado }}</td>

                        <td>{{ $t->fecha_inicio }} / {{ $t->fecha_fin }}</td>

                        <td>
                            @if($t->estado == 'vigente')
                                <span class="badge bg-success">Vigente</span>
                            @elseif($t->estado == 'agotado')
                                <span class="badge bg-danger">Agotado</span>
                            @else
                                <span class="badge bg-secondary">Vencido</span>
                            @endif
                        </td>

                    </tr>
                @endforeach
            </tbody>
        </table>

    </div>
</div>
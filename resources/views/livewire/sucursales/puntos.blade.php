<div class="card card-outline card-secondary">
    <div class="card-header">
        <h3 class="card-title">Puntos de Expedición</h3>
    </div>

    <div class="card-body">

        <div class="row mb-3">

            <div class="col-md-4">
                <select class="form-control" wire:model="sucursal_id">
                    <option value="">Sucursal</option>
                    @foreach($sucursales as $s)
                        <option value="{{ $s->id }}">{{ $s->nombre }}</option>
                    @endforeach
                </select>
            </div>

            <div class="col-md-3">
                <input type="text" class="form-control" wire:model="codigo" placeholder="Código">
            </div>

            <div class="col-md-2">
                <button class="btn btn-dark btn-sm" wire:click="guardar">
                    Guardar
                </button>
            </div>

        </div>

        <table class="table table-sm table-bordered">
            <thead class="bg-light">
                <tr>
                    <th>Sucursal</th>
                    <th style="width: 120px;">Código</th>
                </tr>
            </thead>
            <tbody>
                @foreach($puntos as $p)
                    <tr>
                        <td>{{ $p->sucursal->nombre ?? '' }}</td>
                        <td>{{ $p->codigo }}</td>
                    </tr>
                @endforeach
            </tbody>
        </table>

    </div>
</div>
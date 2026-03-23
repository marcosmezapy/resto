<div class="card card-outline card-secondary">
    <div class="card-header">
        <h3 class="card-title">Sucursales</h3>
    </div>

    <div class="card-body">

        <div class="row mb-3">
            <div class="col-md-2">
                <input type="text" class="form-control" wire:model="codigo" placeholder="Código">
            </div>

            <div class="col-md-3">
                <input type="text" class="form-control" wire:model="nombre" placeholder="Nombre">
            </div>

            <div class="col-md-3">
                <input type="text" class="form-control" wire:model="direccion" placeholder="Dirección">
            </div>

            <div class="col-md-2">
                <input type="text" class="form-control" wire:model="telefono" placeholder="Teléfono">
            </div>

            <div class="col-md-2">
                <input type="text" class="form-control" wire:model="email" placeholder="Email">
            </div>
        </div>

        <div class="text-right mb-3">
            <button class="btn btn-dark btn-sm" wire:click="guardar">
                Guardar
            </button>
        </div>

        <table class="table table-sm table-bordered">
            <thead class="bg-light">
                <tr>
                    <th style="width: 100px;">Código</th>
                    <th>Nombre</th>
                </tr>
            </thead>
            <tbody>
                @foreach($sucursales as $s)
                    <tr>
                        <td>{{ $s->codigo }}</td>
                        <td>{{ $s->nombre }}</td>
                    </tr>
                @endforeach
            </tbody>
        </table>

    </div>
</div>
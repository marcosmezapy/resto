<div class="container-fluid">

    <!-- MENSAJE -->
    @if(session()->has('message'))
        <div class="alert alert-success alert-dismissible fade show" role="alert">
            {{ session('message') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
        </div>
    @endif

    <div class="card">
        <div class="card-header">
            <h3 class="card-title">Configuración de Empresa</h3>
        </div>

        <div class="card-body">

            <form wire:submit.prevent="actualizar">

                <div class="row mb-3">

                    <div class="col-md-6">
                        <label>Razón Social</label>
                        <input type="text" wire:model="razon_social" class="form-control">
                        @error('razon_social') <span class="text-danger">{{ $message }}</span> @enderror
                    </div>

                    <div class="col-md-6">
                        <label>RUC</label>
                        <input type="text" wire:model="ruc" class="form-control">
                        @error('ruc') <span class="text-danger">{{ $message }}</span> @enderror
                    </div>

                </div>

                <div class="row mb-3">

                    <div class="col-md-6">
                        <label>Dirección</label>
                        <input type="text" wire:model="direccion" class="form-control">
                    </div>

                    <div class="col-md-6">
                        <label>Teléfono</label>
                        <input type="text" wire:model="telefono" class="form-control">
                    </div>

                </div>

                <div class="mb-3">
                    <label>Email</label>
                    <input type="email" wire:model="email" class="form-control">
                </div>

                <div class="mb-3">
                    <label>Mensaje para Ticket</label>
                    <textarea wire:model="mensaje_ticket" class="form-control"></textarea>
                </div>

                <button type="submit" class="btn btn-primary">
                    <i class="fas fa-save"></i> Actualizar Datos
                </button>

            </form>

        </div>
    </div>

</div>
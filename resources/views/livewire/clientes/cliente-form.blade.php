<div>

<div class="card">

<div class="card-header">
    <h5 class="mb-0">
        {{ $clienteId ? 'Editar Cliente' : 'Nuevo Cliente' }}
    </h5>
</div>

<div class="card-body">

<div class="row">

<div class="col-md-6">

<div class="form-group">
<label>Nombre *</label>
<input type="text" wire:model="nombre" class="form-control">
@error('nombre') <small class="text-danger">{{ $message }}</small> @enderror
</div>

</div>

<div class="col-md-6">

<div class="form-group">
<label>RUC</label>
<input type="text" wire:model="ruc" class="form-control">
</div>

</div>

<div class="col-md-6">

<div class="form-group">
<label>Teléfono</label>
<input type="text" wire:model="telefono" class="form-control">
</div>

</div>

<div class="col-md-6">

<div class="form-group">
<label>Email</label>
<input type="email" wire:model="email" class="form-control">
@error('email') <small class="text-danger">{{ $message }}</small> @enderror
</div>

</div>

<div class="col-md-12">

<div class="form-group">
<label>Dirección</label>
<input type="text" wire:model="direccion" class="form-control">
</div>

</div>

<div class="col-md-4">

<div class="form-group">
<label>Estado</label>
<select wire:model="activo" class="form-control">
<option value="1">Activo</option>
<option value="0">Inactivo</option>
</select>
</div>

</div>

</div>

</div>

<div class="card-footer text-right">

<a href="{{ route('clientes.index') }}" class="btn btn-default">
Cancelar
</a>

<button wire:click="save" class="btn btn-primary">
Guardar
</button>

</div>

</div>

</div>
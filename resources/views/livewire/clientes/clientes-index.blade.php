<div>

<!-- HEADER -->
<div class="card">

<div class="card-header d-flex justify-content-between align-items-center">

    <h5 class="mb-0">Listado de Clientes</h5>

    <a href="{{ route('clientes.create') }}" class="btn btn-primary btn-sm">
        <i class="fas fa-plus"></i> Nuevo Cliente
    </a>

</div>

<div class="card-body">

<!-- BUSCADOR -->
<div class="row mb-3">
    <div class="col-md-4">
        <input 
            type="text" 
            wire:model.live="search" 
            class="form-control"
            placeholder="Buscar cliente..."
        >
    </div>
</div>

<!-- TABLA -->
<div class="table-responsive">

<table class="table table-bordered table-hover table-sm">

<thead class="thead-light">
<tr>
<th>ID</th>
<th>Nombre</th>
<th>RUC</th>
<th>Teléfono</th>
<th>Email</th>
<th>Estado</th>
<th class="text-center">Acciones</th>
</tr>
</thead>

<tbody>

@forelse($clientes as $cliente)
<tr>

<td>{{ $cliente->id }}</td>

<td>
    <strong>{{ $cliente->nombre }}</strong>
</td>

<td>{{ $cliente->ruc ?? '-' }}</td>

<td>{{ $cliente->telefono ?? '-' }}</td>

<td>{{ $cliente->email ?? '-' }}</td>

<td>
    @if($cliente->activo)
        <span class="badge badge-success">Activo</span>
    @else
        <span class="badge badge-secondary">Inactivo</span>
    @endif
</td>

<td class="text-center">

<a href="{{ route('clientes.show',$cliente->id) }}" 
   class="btn btn-xs btn-default" title="Ver">
    <i class="fas fa-eye"></i>
</a>

<a href="{{ route('clientes.edit',$cliente->id) }}" 
   class="btn btn-xs btn-default" title="Editar">
    <i class="fas fa-edit"></i>
</a>

</td>

</tr>

@empty

<tr>
<td colspan="7" class="text-center text-muted">
No hay registros
</td>
</tr>

@endforelse

</tbody>

</table>

</div>

<!-- PAGINACIÓN -->
<div class="mt-3">
    {{ $clientes->links() }}
</div>

</div>

</div>

</div>
<div>

<div class="mb-3">
<input type="text" wire:model="search" class="form-control" placeholder="Buscar cliente...">
</div>

<table class="table table-bordered table-striped">

<thead class="table-dark">
<tr>
<th>ID</th>
<th>Nombre</th>
<th>RUC</th>
<th>Telefono</th>
<th>Email</th>
<th>Acciones</th>
</tr>
</thead>

<tbody>

@forelse($clientes as $cliente)

<tr>

<td>{{ $cliente->id }}</td>
<td>{{ $cliente->nombre }}</td>
<td>{{ $cliente->ruc }}</td>
<td>{{ $cliente->telefono }}</td>
<td>{{ $cliente->email }}</td>

<td>

@can('clientes.clientes.edit')
<a href="{{ route('clientes.clientes.edit',$cliente) }}" class="btn btn-sm btn-primary">
Editar
</a>
@endcan

@can('clientes.clientes.delete')
<form action="{{ route('clientes.clientes.delete',$cliente) }}" method="POST" class="d-inline">

@csrf
@method('DELETE')

<button class="btn btn-danger btn-sm" onclick="return confirm('Eliminar cliente?')">
Eliminar
</button>

</form>
@endcan

</td>

</tr>

@empty

<tr>
<td colspan="6">Sin registros</td>
</tr>

@endforelse

</tbody>

</table>

{{ $clientes->links() }}

</div>
<div>

<div class="mb-3">
<input type="text" wire:model="search" class="form-control" placeholder="Buscar mesa...">
</div>

<table class="table table-bordered table-striped">

<thead class="table-dark">
<tr>
<th>ID</th>
<th>Mesa</th>
<th>Capacidad</th>
<th>Estado</th>
<th>Acciones</th>
</tr>
</thead>

<tbody>

@forelse($mesas as $mesa)

<tr>

<td>{{ $mesa->id }}</td>

<td>{{ $mesa->numero }}</td>

<td>{{ $mesa->capacidad }}</td>

<td>

@if($mesa->ocupada)

<span class="badge bg-danger">
Ocupada
</span>

@else

<span class="badge bg-success">
Libre
</span>

@endif

</td>

<td>

<a href="{{ route('mesas.mesas.edit',$mesa) }}" class="btn btn-sm btn-primary">
Editar
</a>

<form action="{{ route('mesas.mesas.delete',$mesa) }}" method="POST" class="d-inline">

@csrf
@method('DELETE')

<button class="btn btn-danger btn-sm">
Eliminar
</button>

</form>

</td>

</tr>

@empty

<tr>
<td colspan="5">
No hay mesas registradas
</td>
</tr>

@endforelse

</tbody>

</table>

{{ $mesas->links() }}

</div>
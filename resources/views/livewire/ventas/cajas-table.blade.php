<div>

<div class="mb-3">
<input type="text" wire:model="search" class="form-control" placeholder="Buscar caja...">
</div>

<table class="table table-bordered table-striped">

<thead class="table-dark">

<tr>
<th>ID</th>
<th>Nombre</th>
<th>Descripcion</th>
<th>Estado</th>
<th>Acciones</th>
</tr>

</thead>

<tbody>

@forelse($cajas as $caja)

<tr>

<td>{{ $caja->id }}</td>

<td>{{ $caja->nombre }}</td>

<td>{{ $caja->descripcion }}</td>

<td>

@if($caja->activa)

<span class="badge bg-success">
Activa
</span>

@else

<span class="badge bg-danger">
Inactiva
</span>

@endif

</td>

<td>

@can('ventas.cajas.edit')
<a href="{{ route('ventas.cajas.edit',$caja) }}" class="btn btn-sm btn-primary">
Editar
</a>
@endcan

@can('ventas.cajas.delete')
<form action="{{ route('ventas.cajas.delete',$caja) }}" method="POST" class="d-inline">

@csrf
@method('DELETE')

<button class="btn btn-danger btn-sm">
Eliminar
</button>

</form>
@endcan

</td>

</tr>

@empty

<tr>
<td colspan="5">
No hay cajas registradas
</td>
</tr>

@endforelse

</tbody>

</table>

{{ $cajas->links() }}

</div>
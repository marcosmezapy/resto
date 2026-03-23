<div>

<div class="row mb-3">

<div class="col-md-6">

<div class="card border-danger shadow-sm">

<div class="card-header bg-danger text-white">

<b>Productos sin stock</b>

</div>

<div class="card-body p-0">

<table class="table table-sm table-hover mb-0">

<thead>

<tr>
<th>Producto</th>
<th width="120">Estado</th>
</tr>

</thead>

<tbody>

@forelse($productosSinStock as $producto)

<tr>

<td>{{ $producto->nombre }}</td>

<td>

<span class="badge badge-danger">
Sin stock
</span>

</td>

</tr>

@empty

<tr>
<td colspan="2" class="text-center text-muted">
No hay productos agotados
</td>
</tr>

@endforelse

</tbody>

</table>

</div>

</div>

</div>


<div class="col-md-6">

<div class="card border-warning shadow-sm">

<div class="card-header bg-warning">

<b>Stock bajo</b>

</div>

<div class="card-body p-0">

<table class="table table-sm table-hover mb-0">

<thead>

<tr>
<th>Producto</th>
<th width="120">Stock</th>
</tr>

</thead>

<tbody>

@forelse($productosStockBajo as $producto)

<tr>

<td>{{ $producto->nombre }}</td>

<td>

<span class="badge badge-warning">
{{ $producto->stocks_sum_cantidad }}
</span>

</td>

</tr>

@empty

<tr>
<td colspan="2" class="text-center text-muted">
No hay productos con stock crítico
</td>
</tr>

@endforelse

</tbody>

</table>

</div>

</div>

</div>

</div>

</div>
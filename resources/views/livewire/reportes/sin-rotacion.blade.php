<div>

<div class="card shadow-sm">

<div class="card-header">
<b>Productos sin rotación</b>
</div>

<div class="card-body">

<!-- KPI -->
<div class="row text-center mb-4">

<div class="col-md-6">
<div class="card bg-danger text-white">
<div class="card-body">
<h5>Productos sin rotación</h5>
<h3>{{ $totalProductos }}</h3>
</div>
</div>
</div>

<div class="col-md-6">
<div class="card bg-dark text-white">
<div class="card-body">
<h5>Dinero inmovilizado</h5>
<h3>Gs {{ number_format($dineroDormido,0,',','.') }}</h3>
</div>
</div>
</div>

</div>

<!-- ALERTA -->
<div class="alert alert-warning">
Estos productos no se venden hace más de {{ $this->dias }} días.
</div>

<!-- TABLA -->
<div class="card">
<div class="card-body p-0">

<table class="table table-hover mb-0">

<thead>
<tr>
<th>Producto</th>
<th class="text-end">Stock</th>
<th class="text-end">Días sin venta</th>
<th class="text-end">Valor inmovilizado</th>
</tr>
</thead>

<tbody>

@foreach($productos as $p)

<tr>

<td>{{ $p['nombre'] }}</td>

<td class="text-end">
<b>{{ $p['stock'] }}</b>
</td>

<td class="text-end text-danger">
<b>{{ $p['texto'] }}</b>
</td>

<td class="text-end">
Gs {{ number_format($p['valor'],0,',','.') }}
</td>

</tr>

@endforeach

</tbody>

</table>

</div>
</div>

</div>

</div>

</div>
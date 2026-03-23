<div>

<div class="card shadow-sm">

<div class="card-header">
<b>Stock inteligente</b>
</div>

<div class="card-body">

@php
$critico = $productos->where('estado','CRITICO')->count();
$riesgo = $productos->where('estado','RIESGO')->count();
$muerto = $productos->where('estado','MUERTO')->count();
$lento = $productos->where('estado','LENTO')->count();
@endphp

<!-- KPI -->
<div class="row text-center mb-4">

<div class="col-md-3">
<div class="card bg-danger text-white">
<div class="card-body">
<h5>Sin stock</h5>
<h3>{{ $critico }}</h3>
</div>
</div>
</div>

<div class="col-md-3">
<div class="card bg-warning text-white">
<div class="card-body">
<h5>En riesgo</h5>
<h3>{{ $riesgo }}</h3>
</div>
</div>
</div>

<div class="col-md-3">
<div class="card bg-dark text-white">
<div class="card-body">
<h5>Sin rotación</h5>
<h3>{{ $muerto }}</h3>
</div>
</div>
</div>

<div class="col-md-3">
<div class="card bg-secondary text-white">
<div class="card-body">
<h5>Lento</h5>
<h3>{{ $lento }}</h3>
</div>
</div>
</div>

</div>

<!-- TABLA -->
<div class="card">
<div class="card-header">
<b>Detalle de productos</b>
</div>

<div class="card-body p-0">

<table class="table table-hover mb-0">

<thead>
<tr>
<th>Producto</th>
<th class="text-end">Stock</th>
<th class="text-end">Ventas (30d)</th>
<th class="text-end">Días sin venta</th>
<th class="text-end">Estado</th>
</tr>
</thead>

<tbody>

@foreach($productos as $p)

<tr>

<td>{{ $p['nombre'] }}</td>

<td class="text-end">
<b>{{ $p['stock'] }}</b>
</td>

<td class="text-end">
{{ $p['ventas30'] }}
</td>

<td class="text-end">

<span class="
@if($p['diasSinVenta'] !== null && $p['diasSinVenta'] >= 30) text-danger
@elseif($p['diasSinVenta'] !== null && $p['diasSinVenta'] >= 15) text-warning
@else text-success
@endif
">
<b>{{ $p['diasTexto'] }}</b>
</span>

</td>

<td class="text-end">

@if($p['estado'] == 'CRITICO')
<span class="badge bg-danger">CRÍTICO</span>

@elseif($p['estado'] == 'RIESGO')
<span class="badge bg-warning">RIESGO</span>

@elseif($p['estado'] == 'MUERTO')
<span class="badge bg-dark">SIN ROTACIÓN</span>

@elseif($p['estado'] == 'LENTO')
<span class="badge bg-secondary">LENTO</span>

@else
<span class="badge bg-success">SALUDABLE</span>
@endif

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
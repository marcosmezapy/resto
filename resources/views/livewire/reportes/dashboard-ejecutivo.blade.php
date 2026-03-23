<div>

<!-- KPI -->
<div class="row">

<div class="col-md-3">
<div class="small-box bg-info">
<div class="inner">
<h4>Gs {{ number_format($ventaHoy,0,',','.') }}</h4>
<p>Venta del día</p>
<small>Costo: {{ number_format($costoHoy,0,',','.') }}</small><br>
<small>Utilidad: {{ number_format($utilidadHoy,0,',','.') }}</small>
</div>
</div>
</div>

<div class="col-md-3">
<div class="small-box bg-primary">
<div class="inner">
<h4>Gs {{ number_format($ventaMes,0,',','.') }}</h4>
<p>Mes actual</p>
<small>Mes anterior: {{ number_format($ventaMesAnterior,0,',','.') }}</small>
</div>
</div>
</div>

<div class="col-md-3">
<div class="small-box bg-success">
<div class="inner">
<h4>Gs {{ number_format($ticketPromedio,0,',','.') }}</h4>
<p>Ticket promedio</p>
</div>
</div>
</div>

<div class="col-md-3">
<div class="small-box bg-warning">
<div class="inner">
<h4>{{ $productosVendidosHoy }}</h4>
<p>Productos vendidos hoy</p>
</div>
</div>
</div>

</div>

<!-- SEGUNDA FILA -->
<div class="row">

<div class="col-md-6">
<div class="card">
<div class="card-header"><b>Tendencia (30 días)</b></div>
<div class="card-body">
<canvas id="ventasChart" height="80"></canvas>
</div>
</div>
</div>

<div class="col-md-6">
<div class="card">
<div class="card-header"><b>Top 5 productos (últimos 30 días)</b></div>
<div class="card-body p-0">

<table class="table table-sm mb-0">
<thead>
<tr>
<th>#</th>
<th>Producto</th>
<th class="text-end">Cantidad</th>
</tr>
</thead>
<tbody>
@foreach($topProductos as $i => $p)
<tr>
<td>{{ $i+1 }}</td>
<td>{{ $p->producto->nombre }}</td>
<td class="text-end"><b>{{ $p->total }}</b></td>
</tr>
@endforeach
</tbody>
</table>

</div>
</div>
</div>

</div>

<!-- TERCERA FILA -->
<div class="row">

<div class="col-md-6">
<div class="card">
<div class="card-header"><b>Horas pico</b></div>
<div class="card-body d-flex flex-wrap">

@php $max = max($horas->pluck('total')->toArray()); @endphp

@foreach($horas as $h)
@php $i = $max > 0 ? $h['total'] / $max : 0; @endphp

<div style="
width:45px;height:45px;margin:2px;
background-color: rgba(255,0,0,{{ $i }});
color:white;
display:flex;
align-items:center;
justify-content:center;
font-size:11px;
border-radius:6px;
">
{{ $h['hora'] }}
</div>

@endforeach

</div>
</div>
</div>

<div class="col-md-6">
<div class="card">
<div class="card-header"><b>Salud del stock</b></div>
<div class="card-body">

<div class="mb-2 d-flex justify-content-between">
<span class="text-danger">Sin stock</span>
<b>{{ $sinStock }}</b>
</div>

<div class="progress mb-3">
<div class="progress-bar bg-danger" style="width: {{ $sinStock*10 }}%"></div>
</div>

<div class="mb-2 d-flex justify-content-between">
<span class="text-warning">Stock bajo</span>
<b>{{ $stockBajo }}</b>
</div>

<div class="progress">
<div class="progress-bar bg-warning" style="width: {{ $stockBajo*10 }}%"></div>
</div>

</div>
</div>
</div>

</div>

<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>
new Chart(document.getElementById('ventasChart'), {
type:'line',
data:{
labels:@json($ventasPorDia->pluck('fecha')),
datasets:[{
data:@json($ventasPorDia->pluck('total')),
tension:0.4
}]
},
options:{
plugins:{legend:{display:false}},
scales:{x:{display:false}}
}
});
</script>

</div>
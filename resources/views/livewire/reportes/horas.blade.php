<div>

<div class="card shadow-sm">

<div class="card-header">
<b>Comportamiento por hora</b>
</div>

<div class="card-body">

<!-- FILTROS -->
<div class="row mb-4">

<div class="col-md-3">
<label>Desde</label>
<input type="date" class="form-control" wire:model.live="fecha_inicio">
</div>

<div class="col-md-3">
<label>Hasta</label>
<input type="date" class="form-control" wire:model.live="fecha_fin">
</div>

</div>

<!-- KPI -->
<div class="row text-center mb-4">

<div class="col-md-4">
<div class="card bg-primary text-white">
<div class="card-body">
<h5>Ventas</h5>
<h3>Gs {{ number_format($totalVentas,0,',','.') }}</h3>
</div>
</div>
</div>

<div class="col-md-4">
<div class="card bg-info text-white">
<div class="card-body">
<h5>Transacciones</h5>
<h3>{{ $totalTransacciones }}</h3>
</div>
</div>
</div>

<div class="col-md-4">
<div class="card bg-success text-white">
<div class="card-body">
<h5>Hora pico</h5>
<h3>{{ str_pad($horaTop['hora'],2,'0',STR_PAD_LEFT) }}:00</h3>
</div>
</div>
</div>

</div>

<!-- HEATMAP -->
<div class="card">
<div class="card-header">
<b>Mapa de calor</b>
</div>

<div class="card-body d-flex flex-wrap">

@php
$max = max($horas->pluck('total')->toArray());
@endphp

@foreach($horas as $h)

@php
$intensidad = $max > 0 ? $h['total'] / $max : 0;
@endphp

<div style="
width:60px;
height:60px;
margin:4px;
background: rgba(255,0,0,{{ $intensidad }});
color:white;
display:flex;
flex-direction:column;
align-items:center;
justify-content:center;
border-radius:8px;
font-size:11px;
">

<b>{{ str_pad($h['hora'],2,'0',STR_PAD_LEFT) }}</b>
<small>{{ $h['cantidad'] }}</small>

</div>

@endforeach

</div>
</div>

</div>

</div>

</div>
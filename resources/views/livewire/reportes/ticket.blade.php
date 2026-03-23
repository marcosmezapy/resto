<div>

<div class="card shadow-sm">

<div class="card-header">
<b>Ticket promedio (comportamiento de cliente)</b>
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
<h5>Ticket promedio</h5>
<h3>Gs {{ number_format($ticketPromedio,0,',','.') }}</h3>
</div>
</div>
</div>

<div class="col-md-4">
<div class="card bg-info text-white">
<div class="card-body">
<h5>Ventas</h5>
<h3>{{ $cantidadVentas }}</h3>
</div>
</div>
</div>

<div class="col-md-4">
<div class="card bg-success text-white">
<div class="card-body">
<h5>Total facturado</h5>
<h3>Gs {{ number_format($totalVentas,0,',','.') }}</h3>
</div>
</div>
</div>

</div>

<!-- INSIGHT -->
<div class="row mb-4">

<div class="col-md-6">
<div class="alert alert-success">
Mejor día: <b>{{ $mejor['fecha'] }}</b><br>
Ticket: <b>Gs {{ number_format($mejor['ticket'],0,',','.') }}</b>
</div>
</div>

<div class="col-md-6">
<div class="alert alert-danger">
Peor día: <b>{{ $peor['fecha'] }}</b><br>
Ticket: <b>Gs {{ number_format($peor['ticket'],0,',','.') }}</b>
</div>
</div>

</div>

<!-- GRAFICO -->
<div class="card">
<div class="card-header">
<b>Evolución del ticket</b>
</div>

<div class="card-body">
<canvas id="chartTicket" height="80"></canvas>
</div>
</div>

</div>

</div>

<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>

<script>
document.addEventListener('livewire:navigated', function () {

new Chart(document.getElementById('chartTicket'), {
type: 'line',
data: {
labels: @json($datos->pluck('fecha')),
datasets: [{
data: @json($datos->pluck('ticket')),
tension: 0.4
}]
},
options: {
plugins:{legend:{display:false}},
scales:{x:{display:false}}
}
});

});
</script>

</div>
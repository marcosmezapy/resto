<div>

<div class="card shadow-sm">

<div class="card-header">
<b>Tendencia de ventas</b>
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

<div class="col-md-3">
<div class="card bg-primary text-white">
<div class="card-body">
<h5>Ventas</h5>
<h3>Gs {{ number_format($totalPeriodo,0,',','.') }}</h3>
</div>
</div>
</div>

<div class="col-md-3">
<div class="card bg-info text-white">
<div class="card-body">
<h5>Transacciones</h5>
<h3>{{ $totalVentas }}</h3>
</div>
</div>
</div>

<div class="col-md-3">
<div class="card bg-success text-white">
<div class="card-body">
<h5>Ticket promedio</h5>
<h3>Gs {{ number_format($ticketPromedio,0,',','.') }}</h3>
</div>
</div>
</div>

<div class="col-md-3">
<div class="card {{ $variacion >= 0 ? 'bg-success' : 'bg-danger' }} text-white">
<div class="card-body">
<h5>Variación</h5>
<h3>{{ number_format($variacion,1) }}%</h3>
</div>
</div>
</div>

</div>

<!-- GRAFICO -->
<div class="card">
<div class="card-header">
<b>Evolución diaria</b>
</div>

<div class="card-body">
<canvas id="chartVentas" height="80"></canvas>
</div>
</div>

</div>

</div>

<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>

<script>
document.addEventListener('livewire:navigated', function () {

new Chart(document.getElementById('chartVentas'), {
type: 'line',
data: {
labels: @json($datos->pluck('fecha')),
datasets: [{
data: @json($datos->pluck('total')),
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
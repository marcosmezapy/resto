<div>

<div class="card shadow-sm">

<div class="card-header">
<b>Ventas por día de la semana</b>
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

<!-- INSIGHT -->
<div class="row mb-4">

<div class="col-md-6">
<div class="alert alert-success">
Mejor día: <b>{{ $mejor['dia'] }}</b><br>
Ventas: <b>Gs {{ number_format($mejor['total'],0,',','.') }}</b>
</div>
</div>

<div class="col-md-6">
<div class="alert alert-danger">
Día más débil: <b>{{ $peor['dia'] }}</b><br>
Ventas: <b>Gs {{ number_format($peor['total'],0,',','.') }}</b>
</div>
</div>

</div>

<!-- GRAFICO -->
<div class="card">
<div class="card-header">
<b>Comparación semanal</b>
</div>

<div class="card-body">
<canvas id="chartDias" height="80"></canvas>
</div>
</div>

<!-- TABLA -->
<div class="card mt-3">
<div class="card-body p-0">

<table class="table table-hover mb-0">

<thead>
<tr>
<th>Día</th>
<th class="text-end">Ventas</th>
<th class="text-end">Transacciones</th>
<th class="text-end">Ticket</th>
</tr>
</thead>

<tbody>

@foreach($dias as $d)

<tr>

<td><b>{{ $d['dia'] }}</b></td>

<td class="text-end">
Gs {{ number_format($d['total'],0,',','.') }}
</td>

<td class="text-end">
{{ $d['cantidad'] }}
</td>

<td class="text-end">
Gs {{ number_format($d['ticket'],0,',','.') }}
</td>

</tr>

@endforeach

</tbody>

</table>

</div>
</div>

</div>

</div>

<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>

<script>
document.addEventListener('livewire:navigated', function () {

new Chart(document.getElementById('chartDias'), {
type: 'bar',
data: {
labels: @json($dias->pluck('dia')),
datasets: [{
data: @json($dias->pluck('total'))
}]
},
options: {
plugins:{legend:{display:false}}
}
});

});
</script>

</div>
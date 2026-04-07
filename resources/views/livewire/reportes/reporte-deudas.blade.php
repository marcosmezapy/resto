<div>

<div class="card">

<div class="card-header">
    <h5 class="mb-0">Reporte de Deudas a Cobrar</h5>
</div>

<div class="card-body">

<!-- 🔎 FILTROS -->
<div class="row mb-3">

<div class="col-md-3">
<select wire:model.live="cliente_id" class="form-control">
<option value="">Todos los clientes</option>
@foreach($clientes as $c)
<option value="{{ $c->id }}">{{ $c->nombre }}</option>
@endforeach
</select>
</div>

<div class="col-md-2">
<select wire:model.live="estado" class="form-control">
<option value="">Todos</option>
<option value="vencido">Vencidos</option>
<option value="al_dia">Al día</option>
</select>
</div>

<div class="col-md-2">
<input type="date" wire:model.live="fecha_desde" class="form-control">
</div>

<div class="col-md-2">
<input type="date" wire:model.live="fecha_hasta" class="form-control">
</div>

</div>

<!-- 🔷 KPIs -->
<div class="row mb-3">

<div class="col-md-3">
<div class="card">
<div class="card-body">
<h6>Total Deuda</h6>
<h4>Gs. {{ number_format($totalDeuda,0,',','.') }}</h4>
</div>
</div>
</div>

<div class="col-md-3">
<div class="card">
<div class="card-body">
<h6>Total Vencido</h6>
<h4 class="text-danger">
Gs. {{ number_format($totalVencido,0,',','.') }}
</h4>
</div>
</div>
</div>

<div class="col-md-3">
<div class="card">
<div class="card-body">
<h6>Documentos</h6>
<h4>{{ $cantidad }}</h4>
</div>
</div>
</div>

<div class="col-md-3">
<div class="card">
<div class="card-body">
<h6>Vencidas</h6>
<h4 class="text-danger">{{ $vencidas }}</h4>
</div>
</div>
</div>

</div>

<!-- 📊 GRÁFICO SIMPLE -->
<div class="card mb-3">
<div class="card-body">

<div class="progress">
<div class="progress-bar bg-secondary" style="width: 100%">
Total
</div>
<div class="progress-bar bg-danger" 
     style="width: {{ $totalDeuda ? ($totalVencido/$totalDeuda)*100 : 0 }}%">
Vencido
</div>
</div>

</div>
</div>

<!-- 📋 TABLA -->
<div class="table-responsive">

<table class="table table-bordered table-hover table-sm">

<thead class="thead-light">
<tr>
<th>Cliente</th>
<th>Documento</th>
<th>Total</th>
<th>Saldo</th>
<th>Vencimiento</th>
<th class="text-center">Acción</th>
</tr>
</thead>

<tbody>

@foreach($ventas as $v)

<tr class="{{ $v->fecha_vencimiento && $v->fecha_vencimiento < now() ? 'table-danger' : '' }}">

<td>{{ $v->cliente->nombre ?? '-' }}</td>

<td>
<strong>{{ ucfirst($v->tipo_documento) }}</strong><br>
<small>{{ $v->numero_documento }}</small>
</td>

<td>Gs. {{ number_format($v->total,0,',','.') }}</td>

<td class="text-danger">
Gs. {{ number_format($v->saldo,0,',','.') }}
</td>

<td>
@if($v->fecha_vencimiento)
{{ \Carbon\Carbon::parse($v->fecha_vencimiento)->format('d/m/Y') }}
@endif
</td>

<td class="text-center">
<a href="{{ route('ventas.historial.show',$v->id) }}" 
   class="btn btn-default btn-xs">
Ver compra
</a>
</td>

</tr>

@endforeach

</tbody>

</table>

</div>

<div class="mt-3">
{{ $ventas->links() }}
</div>

</div>

</div>

</div>
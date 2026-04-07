<div>

<!-- 🔷 HEADER -->
<div class="card mb-3">
<div class="card-body">

<h4 class="mb-1">{{ $cliente->nombre }}</h4>

<div class="row">

<div class="col-md-3"><b>RUC:</b> {{ $cliente->ruc ?? '-' }}</div>
<div class="col-md-3"><b>Teléfono:</b> {{ $cliente->telefono ?? '-' }}</div>
<div class="col-md-3"><b>Email:</b> {{ $cliente->email ?? '-' }}</div>
<div class="col-md-3"><b>Estado:</b> {{ $cliente->activo ? 'Activo' : 'Inactivo' }}</div>

</div>

</div>
</div>


<!-- 🔷 KPIs -->
<div class="row">

<div class="col-md-3">
<div class="card">
<div class="card-body">
<h6>Total Comprado</h6>
<h4>Gs. {{ number_format($stats['total'],0,',','.') }}</h4>
</div>
</div>
</div>

<div class="col-md-3">
<div class="card">
<div class="card-body">
<h6>Ticket Promedio</h6>
<h4>Gs. {{ number_format($stats['ticket'],0,',','.') }}</h4>
</div>
</div>
</div>

<div class="col-md-3">
<div class="card">
<div class="card-body">
<h6>Frecuencia</h6>
<h4>{{ round($stats['frecuencia'],1) }} días</h4>
</div>
</div>
</div>

<div class="col-md-3">
<div class="card">
<div class="card-body">
<h6>Última compra</h6>
<h4>{{ $stats['ultima'] ? \Carbon\Carbon::parse($stats['ultima'])->format('d/m/Y') : '-' }}</h4>
</div>
</div>
</div>

</div>


<!-- 🔷 CRÉDITO -->
<!-- 🔷 CRÉDITO -->
<div class="card mt-3">
<div class="card-header">
<b>Deuda del Cliente (Pendientes)</b>
</div>

<div class="card-body">

<div class="row mb-3">

<div class="col-md-4">
<b>Total deuda:</b><br>
Gs. {{ number_format($credito['total'],0,',','.') }}
</div>

<div class="col-md-4">
<b>Facturas:</b><br>
{{ $credito['cantidad'] }}
</div>

<div class="col-md-4">
<b>Vencidas:</b><br>
<span class="text-danger">{{ $credito['vencidas'] }}</span>
</div>

</div>

<div class="table-responsive">
<table class="table table-sm table-bordered">

<thead>
<tr>
<th>Fecha</th>
<th>Tipo</th>
<th>Documento</th>
<th>Total</th>
<th>Saldo</th>
<th>Vencimiento</th>
<th class="text-center">Acción</th>
</tr>
</thead>

<tbody>

@forelse($credito['pendientes'] as $v)
<tr class="{{ $v->fecha_vencimiento && $v->fecha_vencimiento < now() ? 'table-danger' : '' }}">

<td>{{ $v->created_at->format('d/m/Y') }}</td>
<td>{{ $v->tipo_documento ?? 'Doc' }}</td>
<td>{{ $v->numero_documento ?? 'Sin número' }}</td>

<td>Gs. {{ number_format($v->total,0,',','.') }}</td>

<td class="text-danger">
Gs. {{ number_format($v->saldo,0,',','.') }}
</td>

<td>
@if($v->fecha_vencimiento)
    {{ \Carbon\Carbon::parse($v->fecha_vencimiento)->format('d/m/Y') }}

    @if($v->fecha_vencimiento < now())
        <br><small class="text-danger">Vencido</small>
    @endif
@endif
</td>

<td class="text-center">
<a href="{{ route('ventas.historial.show', $v->id) }}" 
   class="btn btn-default btn-xs">
    Ver
</a>
</td>

</tr>
@empty
<tr>
<td colspan="7" class="text-center text-muted">
No hay deudas pendientes
</td>
</tr>
@endforelse

</tbody>

</table>
</div>

<div class="mt-2">
    {{ $credito['pendientes']->links() }}
</div>

</div>
</div>

<!-- 🔷 TODAS LAS COMPRAS -->
<div class="card mt-3">
<div class="card-header">
<b>Historial de Compras</b>
</div>

<div class="card-body">

<div class="table-responsive">
<table class="table table-sm table-bordered">

<thead>
<tr>
<th>Fecha</th>
<th>Tipo</th>
<th>Documento</th>
<th>Total</th>
<th>Estado</th>
<th class="text-center">Acción</th>
</tr>
</thead>

<tbody>

@forelse($credito['todas'] as $v)
<tr>

<td>{{ $v->created_at->format('d/m/Y') }}</td>
<td>{{ $v->tipo_documento ?? 'Doc' }}</td>
<td>{{ $v->numero_documento ?? 'Sin número' }}</td>

<td>Gs. {{ number_format($v->total,0,',','.') }}</td>

<td>
@if($v->estado == 'cancelada')
    <span class="badge badge-danger">Cancelado</span>

@elseif($v->estado_pago == 'pagado')
    <span class="badge badge-success">Pagado</span>

@else
    <span class="badge badge-warning">Pendiente</span>
@endif
</td>

<td class="text-center">
<a href="{{ route('ventas.historial.show', $v->id) }}" 
   class="btn btn-default btn-xs">
    Ver
</a>
</td>

</tr>
@empty
<tr>
<td colspan="6" class="text-center text-muted">
Sin compras
</td>
</tr>
@endforelse

</tbody>

</table>
</div>

<div class="mt-2">
    {{ $credito['todas']->links() }}
</div>

</div>
</div>

</div>
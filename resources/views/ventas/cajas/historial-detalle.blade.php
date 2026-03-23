@extends('adminlte::page')

@section('title','Detalle de Caja')

@section('content')

<div class="container-fluid pt-3">

{{-- 🔝 HEADER --}}
<div class="mb-3">
    <h5 class="mb-1">
        Caja: <strong>{{ $caja->caja->nombre }}</strong>
    </h5>
    <small class="text-muted">
        Aperturada el 
        {{ \Carbon\Carbon::parse($caja->fecha_apertura)->format('d/m/Y H:i') }}
        por 
        <strong>{{ $caja->usuario->name }}</strong>
    </small>
</div>


{{-- 🔥 BLOQUE SUPERIOR --}}
<div class="row">

{{-- VENTAS POR METODO --}}
<div class="col-md-4">
<div class="card h-100">

<div class="card-header">
<b>Ventas por Método</b>
</div>

<div class="card-body">

<p class="mb-2">💵 Efectivo<br>
<strong>Gs. {{ number_format($efectivo,0,',','.') }}</strong>
</p>

<p class="mb-2">💳 Tarjeta<br>
<strong>Gs. {{ number_format($tarjeta,0,',','.') }}</strong>
</p>

<p class="mb-0">🏦 Transferencia<br>
<strong>Gs. {{ number_format($transferencia,0,',','.') }}</strong>
</p>

</div>

</div>
</div>


{{-- ARQUEO --}}
<div class="col-md-4">
<div class="card h-100">

<div class="card-header">
<b>Arqueo de Caja</b>
</div>

<div class="card-body">

<p class="mb-1">Apertura:<br>
<strong>Gs. {{ number_format($caja->monto_apertura,0,',','.') }}</strong>
</p>

<p class="mb-1">Esperado:<br>
<strong>Gs. {{ number_format($esperado,0,',','.') }}</strong>
</p>

<p class="mb-1">Contado:<br>
<strong>Gs. {{ number_format($caja->monto_contado,0,',','.') }}</strong>
</p>

<hr>

<p class="mb-0">
<b>Diferencia:</b><br>
<span class="{{ ($caja->monto_contado - $esperado) >= 0 ? 'text-success' : 'text-danger' }}">
Gs. {{ number_format($caja->monto_contado - $esperado,0,',','.') }}
</span>
</p>

</div>

</div>
</div>


{{-- 🔥 MOVIMIENTOS DETALLADOS --}}
<div class="col-md-4">
<div class="card h-100">

<div class="card-header">
<b>Movimientos de Caja</b>
</div>

<div class="card-body p-0">

@if($movimientos->count())

<table class="table table-sm mb-0">

<thead class="table-light">
<tr>
<th>Tipo</th>
<th>Detalle</th>
<th class="text-right">Monto</th>
</tr>
</thead>

<tbody>

@foreach($movimientos->take(8) as $mov)
<tr>

<td>
@if($mov->tipo=='ingreso')
<span class="badge bg-success">Ingreso</span>
@endif

@if($mov->tipo=='gasto')
<span class="badge bg-danger">Gasto</span>
@endif

@if($mov->tipo=='retiro')
<span class="badge bg-warning">Retiro</span>
@endif
</td>

<td>
<div>{{ $mov->descripcion }}</div>
<small class="text-muted">
{{ \Carbon\Carbon::parse($mov->created_at)->format('d/m/Y H:i') }}
</small>
</td>

<td class="text-right">
Gs. {{ number_format($mov->monto,0,',','.') }}
</td>

</tr>
@endforeach

</tbody>

</table>

@else

<div class="p-3 text-muted">
No hubo movimientos
</div>

@endif

</div>

</div>
</div>

</div>


{{-- 🔽 VENTAS FULL WIDTH --}}
<div class="row mt-3">

<div class="col-md-12">

<div class="card">

<div class="card-header">
<b>Ventas de la Caja</b>
</div>

<div class="card-body">

@if($ventas->count())

<table class="table table-bordered table-striped table-sm">

<thead>
<tr>
<th>ID</th>
<th>Tipo Venta</th>
<th>Cliente</th>
<th>Total</th>
<th>Estado</th>
<th>Fecha</th>
<th>Acción</th>
</tr>
</thead>

<tbody>

@foreach($ventas as $venta)

<tr>

<td>{{ $venta->id }}</td>

<td>
@if($venta->mesa_id)
    MESA - {{ $venta->mesa->numero ?? '-' }}
@else
    DIRECTA
@endif
</td>

<td>
{{ $venta->cliente->nombre ?? 'Consumidor Final' }}
</td>

<td>
Gs. {{ number_format($venta->total,0,',','.') }}
</td>

<td>
@if($venta->estado == 'pagada')
<span class="badge bg-success">Pagada</span>
@elseif($venta->estado == 'cancelada')
<span class="badge bg-danger">Cancelada</span>
@else
<span class="badge bg-warning">Abierta</span>
@endif
</td>

<td>
{{ \Carbon\Carbon::parse($venta->created_at)->format('d/m/Y H:i') }}
</td>

<td>
<a href="{{ route('ventas.historial.show',$venta->id) }}"
class="btn btn-sm btn-primary">
Ver
</a>
</td>

</tr>

@endforeach

</tbody>

</table>

@else

<div class="alert alert-info">
No hay ventas en esta caja
</div>

@endif

</div>

</div>

</div>

</div>

</div>

@endsection
@section('footer')
    @include('adminlte::partials.footer.footer')
@endsection

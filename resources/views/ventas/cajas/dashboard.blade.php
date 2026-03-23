@extends('adminlte::page')

@section('title','Caja')

@section('content')

@if(session('error'))
<div class="alert alert-danger">
    {{ session('error') }}
</div>
@endif

<div class="container-fluid mt-3">

<div class="mb-3">

    <h5 class="mb-1">
        Caja: <strong>{{ $sesion->caja->nombre ?? 'N/A' }}</strong>
    </h5>

    <small class="text-muted">
        Aperturada el 
        {{ \Carbon\Carbon::parse($sesion->fecha_apertura)->format('d/m/Y H:i') }}
        por 
        <strong>{{ $sesion->usuario->name ?? 'Usuario' }}</strong>
    </small>

</div>

{{-- 🔥 CUADROS SUPERIORES (SE MANTIENEN) --}}
<div class="row">

<div class="col-md-3">
<div class="card bg-success">
<div class="card-body text-center">
<h6>Efectivo</h6>
<h4>Gs. {{ number_format($efectivo,0,',','.') }}</h4>
</div>
</div>
</div>

<div class="col-md-3">
<div class="card bg-info">
<div class="card-body text-center">
<h6>Tarjeta</h6>
<h4>Gs. {{ number_format($tarjeta,0,',','.') }}</h4>
</div>
</div>
</div>

<div class="col-md-3">
<div class="card bg-warning">
<div class="card-body text-center">
<h6>Transferencia</h6>
<h4>Gs. {{ number_format($transferencia,0,',','.') }}</h4>
</div>
</div>
</div>

<div class="col-md-3">
<div class="card bg-dark">
<div class="card-body text-center">
<h6>Pendiente</h6>
<h4>Gs. {{ number_format($pendiente,0,',','.') }}</h4>
</div>
</div>
</div>

</div>

<hr>

{{-- 🔥 VENTAS ABIERTAS + MOVIMIENTOS --}}
<div class="row">

<div class="col-md-6">
<div class="card">

<div class="card-header">
Ventas abiertas
</div>

<div class="card-body">

@if($ventasAbiertas->count())

<table class="table table-sm">
<thead>
<tr>
<th>Tipo</th>
<th>Total</th>
</tr>
</thead>

<tbody>
@foreach($ventasAbiertas as $venta)
<tr>

<td>
@if($venta->mesa_id)
    MESA - {{ $venta->mesa->numero ?? '-' }}
@else
    DIRECTA
@endif
</td>

<td>
Gs. {{ number_format($venta->total,0,',','.') }}
</td>

</tr>
@endforeach
</tbody>
</table>

@else
<div class="alert alert-success">
No hay ventas abiertas
</div>
@endif

</div>
</div>
</div>


<div class="col-md-6">
<div class="card">

<div class="card-header">
Movimientos de caja
</div>

<div class="card-body">

@if($movimientos->count())

<table class="table table-sm">

<thead>
<tr>
<th>Tipo</th>
<th>Monto</th>
</tr>
</thead>

<tbody>

@foreach($movimientos as $mov)
<tr>

<td>
@if($mov->tipo=='ingreso') <span class="badge bg-success">Ingreso</span> @endif
@if($mov->tipo=='gasto') <span class="badge bg-danger">Gasto</span> @endif
@if($mov->tipo=='retiro') <span class="badge bg-warning">Retiro</span> @endif
</td>

<td>Gs. {{ number_format($mov->monto,0,',','.') }}</td>

</tr>
@endforeach

</tbody>
</table>

@else
<div class="alert alert-info">Sin movimientos</div>
@endif

</div>
</div>
</div>

</div>

<hr>

{{-- 🔥 RESUMEN ABAJO --}}
<div class="row">

<div class="col-md-12">
<div class="card">

<div class="card-header">
Resumen de caja
</div>

<div class="card-body">

<p><strong>Apertura:</strong> Gs. {{ number_format($sesion->monto_apertura,0,',','.') }}</p>

<hr>

<h6>Flujo en efectivo</h6>

<p>Efectivo ventas: Gs. {{ number_format($efectivo,0,',','.') }}</p>
<p>+ Ingresos: Gs. {{ number_format($ingresos,0,',','.') }}</p>
<p>- Gastos: Gs. {{ number_format($gastos,0,',','.') }}</p>
<p>- Retiros: Gs. {{ number_format($retiros,0,',','.') }}</p>

<hr>

<p><strong>Total en caja (esperado):</strong>
Gs. {{ number_format($cajaEsperada,0,',','.') }}</p>

<hr>

<h6>Ventas por otros medios</h6>

<p>Tarjeta: Gs. {{ number_format($tarjeta,0,',','.') }}</p>
<p>Transferencia: Gs. {{ number_format($transferencia,0,',','.') }}</p>

<hr>

<a href="{{ route('ventas.cajas.movimiento') }}" class="btn btn-warning btn-block">
Registrar Movimiento
</a>

<a href="{{ route('ventas.cajas.cerrar') }}" class="btn btn-danger btn-block">
Cerrar Caja
</a>

</div>
</div>
</div>

</div>

</div>

@endsection
@section('footer')
    @include('adminlte::partials.footer.footer')
@endsection

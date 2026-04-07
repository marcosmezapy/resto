@extends('adminlte::page')

@section('title','Cerrar Caja')

@section('content_header')

<h1>Cierre de Caja</h1>

<div class="mb-3">
    <h5>
        Caja: <strong>{{ $caja->caja->nombre ?? 'N/A' }}</strong>
    </h5>
</div>

@stop


@section('content')

<div class="row">

<!-- IZQUIERDA -->
<div class="col-md-6">

<!-- INGRESOS -->
<div class="card mb-3">
<div class="card-header">
<b>Ingresos del Turno</b>
</div>

<div class="card-body">

<table class="table table-bordered table-sm">

<tr>
<td>Efectivo</td>
<td class="text-right">Gs. {{ number_format($efectivo,0,',','.') }}</td>
</tr>

<tr>
<td>Tarjeta</td>
<td class="text-right">Gs. {{ number_format($tarjeta,0,',','.') }}</td>
</tr>

<tr>
<td>Transferencia</td>
<td class="text-right">Gs. {{ number_format($transferencia,0,',','.') }}</td>
</tr>

<tr class="table-primary">
<td><b>Total Cobrado</b></td>
<td class="text-right">
<b>Gs. {{ number_format($totalCobrado,0,',','.') }}</b>
</td>
</tr>

<tr>
<td>Ventas Crédito</td>
<td class="text-right text-warning">
Gs. {{ number_format($credito,0,',','.') }}
</td>
</tr>

</table>

<div class="alert alert-warning mt-3">
<b>IMPORTANTE:</b><br>
Las ventas a crédito NO forman parte del dinero en caja.
</div>

</div>
</div>

</div>


<!-- DERECHA -->
<div class="col-md-6">

<!-- FLUJO -->
<div class="card mb-3">
<div class="card-header">
<b>Flujo de Caja</b>
</div>

<div class="card-body">

<table class="table table-bordered table-sm">

<tr>
<td>Apertura</td>
<td class="text-right">Gs. {{ number_format($caja->monto_apertura,0,',','.') }}</td>
</tr>

<tr>
<td>+ Efectivo ventas</td>
<td class="text-right">Gs. {{ number_format($efectivo,0,',','.') }}</td>
</tr>

<tr>
<td>+ Ingresos</td>
<td class="text-right">Gs. {{ number_format($ingresos,0,',','.') }}</td>
</tr>

<tr>
<td>- Gastos</td>
<td class="text-right text-danger">Gs. {{ number_format($gastos,0,',','.') }}</td>
</tr>

<tr>
<td>- Retiros</td>
<td class="text-right text-danger">Gs. {{ number_format($retiros,0,',','.') }}</td>
</tr>

<tr class="table-success">
<td><b>Total Esperado</b></td>
<td class="text-right">
<b>Gs. {{ number_format($totalEsperado,0,',','.') }}</b>
</td>
</tr>

</table>

</div>
</div>


<!-- CIERRE DE CAJA -->
<div class="card border-danger">
<div class="card-header bg-danger text-white">
<b>Confirmar Cierre de Caja</b>
</div>

<div class="card-body">

<form method="POST" action="{{ route('ventas.cajas.cerrar.store') }}">
@csrf

<input type="hidden" name="caja_id" value="{{ $caja->id }}">

<div class="form-group">
<label><b>Monto contado (efectivo real)</b></label>
<input 
    type="number" 
    name="monto_contado" 
    class="form-control"
    placeholder="Ingrese el efectivo contado"
    required
>
<small class="text-muted">
Ingrese el dinero REAL contado, no el esperado.
</small>
</div>

<hr>

<p>
<b>Esperado:</b> Gs. {{ number_format($totalEsperado,0,',','.') }}
</p>

<button class="btn btn-danger btn-block">
Cerrar Caja
</button>

</form>

</div>
</div>

</div>

</div>

@endsection
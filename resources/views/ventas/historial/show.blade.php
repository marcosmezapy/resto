@extends('adminlte::page')

@section('title','Detalle de Venta')

@section('content')

@if(session('success'))

<div class="alert alert-success">
{{ session('success') }}
</div>

@endif


@if(session('error'))

<div class="alert alert-danger">
{{ session('error') }}
</div>

@endif


<div class="card">

<div class="card-header">
<b>Detalle de Venta #{{ $venta->id }}</b>
</div>

<div class="card-body">

<div class="row mb-3">

<div class="col-md-3">
<b>Tipo de Venta:</b><br>
{{ ucfirst($venta->tipo_venta) }}
</div>

<div class="col-md-3">
<b>Mesa:</b><br>
@if($venta->mesa)
Mesa {{ $venta->mesa->id }}
@else
No aplica
@endif
</div>

<div class="col-md-3">
<b>Estado:</b><br>

@if($venta->estado == 'cancelada')
<span class="badge badge-danger">Cancelada</span>
@else
<span class="badge badge-success">{{ $venta->estado }}</span>
@endif

</div>

<div class="col-md-3">
<b>Total:</b><br>
Gs {{ number_format($venta->total,0,',','.') }}
</div>

</div>


<div class="row mb-3">

<div class="col-md-6">

<b>Cliente:</b><br>

@if($venta->cliente)

<strong>{{ $venta->cliente->nombre }}</strong>

@if($venta->cliente->ruc)
<br>
RUC: {{ $venta->cliente->ruc }}
@endif

@else

<span class="text-muted">
Cliente genérico
</span>

@endif

</div>

</div>


<hr>


<h5>Productos</h5>

<table class="table table-bordered table-sm">

<thead>

<tr>
<th>Producto</th>
<th>Cantidad</th>
<th>Precio</th>
<th>Subtotal</th>
</tr>

</thead>

<tbody>

@foreach($venta->detalles as $detalle)

<tr>

<td>{{ $detalle->producto->nombre }}</td>

<td>{{ $detalle->cantidad }}</td>

<td>
Gs {{ number_format($detalle->precio,0,',','.') }}
</td>

<td>
Gs {{ number_format($detalle->subtotal,0,',','.') }}
</td>

</tr>

@endforeach

</tbody>

</table>


<hr>


<h5>Pagos</h5>

<table class="table table-bordered table-sm">

<thead>

<tr>
<th>Método</th>
<th>Monto</th>
</tr>

</thead>

<tbody>

@foreach($venta->pagos as $pago)

<tr>

<td>{{ ucfirst($pago->metodo_pago) }}</td>

<td>
Gs {{ number_format($pago->monto,0,',','.') }}
</td>

</tr>

@endforeach

</tbody>

</table>



<div class="mt-3 d-flex gap-2">

<a href="{{ route('ventas.historial.index') }}" class="btn btn-secondary">
Volver
</a>


@if($venta->estado != 'cancelada')

<form method="POST"
action="{{ route('ventas.historial.anular',$venta->id) }}"
onsubmit="return confirm('¿Seguro que deseas anular esta venta? Esta acción devolverá el stock.');">

@csrf

<button class="btn btn-danger">
Anular venta
</button>

</form>

@else

<span class="badge badge-danger p-2">
Venta anulada
</span>

@endif


</div>


</div>

</div>

@endsection
@section('footer')
    @include('adminlte::partials.footer.footer')
@endsection

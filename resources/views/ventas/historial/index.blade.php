@extends('adminlte::page')

@section('title','Historial de Ventas')

@section('content')

<div class="card">

<div class="card-header">
<b>Ventas</b>
</div>

<div class="card-body">

<table class="table table-bordered table-sm">

<thead>
<tr>

<th>ID</th>
<th>Tipo</th>
<th>Mesa</th>
<th>Cliente</th>
<th>Total</th>
<th>Estado</th>
<th></th>

</tr>
</thead>

<tbody>

@foreach($ventas as $venta)

<tr>

<td>{{ $venta->id }}</td>

<td>{{ $venta->tipo_venta }}</td>

<td>

{{ $venta->mesa ? 'Mesa '.$venta->mesa->id : 'No aplica' }}

</td>

<td>

@if($venta->cliente)

<strong>{{ $venta->cliente->nombre }}</strong>

@if($venta->cliente->ruc)
<br>
<small>RUC: {{ $venta->cliente->ruc }}</small>
@endif

@else

<span class="text-muted">
Cliente genérico
</span>

@endif

</td>

<td>
Gs {{ number_format($venta->total,0,',','.') }}
</td>

<td>{{ $venta->estado }}</td>

<td>

<a href="{{ route('ventas.historial.show',$venta->id) }}" class="btn btn-sm btn-primary">
Ver
</a>

</td>

</tr>

@endforeach

</tbody>

</table>

<div class="mt-2 d-flex justify-content-center">
    {{ $ventas->links('pagination::bootstrap-4') }}
</div>

</div>

</div>

@endsection
@section('footer')
    @include('adminlte::partials.footer.footer')
@endsection

@extends('adminlte::page')

@section('title','Historial de Cajas')

@section('content')

<div class="card">

<div class="card-header">
<b>Historial de Sesiones de Caja</b>
</div>

<div class="card-body">

<table class="table table-bordered table-striped">

<thead>

<tr>

<th>ID</th>
<th>Caja</th>
<th>Usuario</th>
<th>Apertura</th>
<th>Cierre</th>
<th>Monto Apertura</th>
<th>Monto Contado</th>
<th>Estado</th>
<th></th>

</tr>

</thead>

<tbody>

@foreach($cajas as $caja)

<tr>

<td>{{ $caja->id }}</td>

<td>{{ $caja->caja->nombre }}</td>

<td>{{ $caja->usuario->name }}</td>

<td>{{ \Carbon\Carbon::parse($caja->fecha_apertura)->format('d/m/Y H:i') }}</td>

<td>
    @if($caja->fecha_cierre)

{{ \Carbon\Carbon::parse($caja->fecha_cierre)->format('d/m/Y H:i') }}

@endif
</td>

<td>
Gs. {{ number_format($caja->monto_apertura,0,',','.') }}
</td>

<td>
Gs. {{ number_format($caja->monto_contado,0,',','.') }}
</td>

<td>

@if($caja->estado=='abierta')

<span class="badge bg-success">
Abierta
</span>

@else

<span class="badge bg-secondary">
Cerrada
</span>

@endif

</td>

<td>

<a
href="{{ route('ventas.cajas.historial.detalle',$caja->id) }}"
class="btn btn-sm btn-primary">

Ver ventas

</a>

</td>

</tr>

@endforeach

</tbody>

</table>

</div>

</div>

@endsection
@section('footer')
    @include('adminlte::partials.footer.footer')
@endsection

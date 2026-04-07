<div>

<div class="card">

<div class="card-body">

<!-- 🔷 HEADER EJECUTIVO -->
<div class="row mb-3">

<div class="col-md-4">
<h5 class="mb-1">{{ $venta->cliente->nombre ?? 'Consumidor Final' }}</h5>
<small class="text-muted">
RUC: {{ $venta->cliente->ruc ?? '-' }}
</small>
</div>

<div class="col-md-2">
<b>Documento</b><br>
{{ ucfirst($venta->tipo_documento) }}<br>
<small>{{ $venta->numero_documento }}</small>
</div>

<div class="col-md-2">
<b>Condición</b><br>
{{ ucfirst($venta->condicion_pago) }}
</div>

<div class="col-md-2">
<b>Estado</b><br>
<span class="badge 
    @if($venta->estado_pago == 'pagado') badge-success
    @elseif($venta->estado_pago == 'cancelado') badge-danger
    @else badge-warning
    @endif
">
    {{ ucfirst($venta->estado_pago) }}
</span>
</div>

<div class="col-md-2 text-right">
<b>Total</b><br>
Gs {{ number_format($venta->total,0,',','.') }}

@if($venta->saldo > 0)
<br>
<small class="text-danger">
Saldo: {{ number_format($venta->saldo,0,',','.') }}
</small>
@endif
</div>

</div>

<hr>

<!-- 🔷 PRODUCTOS -->
<h6>Detalle</h6>

<table class="table table-sm table-bordered">
@foreach($venta->detalles as $d)
<tr>
<td>{{ $d->producto->nombre }}</td>
<td>{{ $d->cantidad }}</td>
<td>{{ number_format($d->subtotal,0,',','.') }}</td>
</tr>
@endforeach
</table>

<hr>

<!-- 🔷 PAGOS -->
<h6>Historial de Pagos</h6>

<table class="table table-sm table-bordered">
@foreach($venta->pagos as $p)
<tr>
<td>{{ ucfirst($p->metodo_pago) }}</td>
<td>Gs {{ number_format($p->monto,0,',','.') }}</td>
<td>
<small>{{ $p->created_at }}</small>
</td>
<td>
<a href="{{ route('ventas.recibo',$p->id) }}" 
   class="btn btn-default btn-xs">
Recibo
</a>
</td>
</tr>
@endforeach
</table>

<!-- 🔥 COBRO REAL -->
@if($venta->estado != 'cancelada' && $venta->estado_pago != 'pagado')

<div class="card mt-3">
<div class="card-header">
<b>Registrar Cobro</b>
</div>

<div class="card-body">

<div class="row">

<div class="col-md-3">
<label>Monto</label>
<input type="number" wire:model="monto" class="form-control">
</div>

<div class="col-md-3">
<label>Método</label>
<select wire:model="metodo_pago" class="form-control">
<option value="efectivo">Efectivo</option>
<option value="transferencia">Transferencia</option>
<option value="tarjeta">Tarjeta</option>
</select>
</div>

<div class="col-md-4">
<label>Referencia</label>
<input type="text" wire:model="referencia" class="form-control">
</div>

<div class="col-md-2 d-flex align-items-end">
<button wire:click="registrarPago" class="btn btn-success btn-block">
Cobrar
</button>
</div>

</div>

</div>
</div>

@endif

<hr>

<!-- 🔷 ACCIONES -->
<div class="d-flex gap-2">

<a href="{{ route('ventas.print',$venta->id) }}" 
   class="btn btn-default">
Reimprimir
</a>

@if($venta->estado != 'cancelada')

<button wire:click="anular" class="btn btn-danger">
Anular
</button>

@endif

</div>

</div>

</div>

</div>
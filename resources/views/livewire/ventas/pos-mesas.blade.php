<div wire:poll.10s>

<div class="row">

@foreach($mesas as $mesa)

<div class="col-md-3 mb-4">

<a href="{{ route('ventas.pos.mesa',$mesa->id) }}" class="text-decoration-none">

<div class="card mesa-card
@if($mesa->ocupada)
mesa-ocupada
@else
mesa-libre
@endif
">

<div class="card-body text-center">

<h3 class="mb-2">
Mesa {{ $mesa->numero }}
</h3>

@if($mesa->ocupada)

<span class="badge badge-danger">
Ocupada
</span>

<div class="mt-2 text-muted">
💰 Gs. {{ number_format($mesa->total,0,',','.') }}
</div>

<div class="text-muted">
⏱ {{ $mesa->tiempo }}
</div>

@else

<span class="badge badge-success">
Libre
</span>

@endif

</div>

</div>

</a>

</div>

@endforeach

</div>

</div>
@foreach($productos as $p)
<div>{{ $p['nombre'] }} - {{ $p['utilidad'] }}</div>
@endforeach
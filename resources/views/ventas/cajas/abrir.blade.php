@extends('adminlte::page')

@section('content')

<div class="container">

<h2>Abrir Caja</h2>

<form method="POST" action="{{ route('ventas.cajas.storeSesion') }}">
@csrf

<div class="card">

<div class="card-body">

<div class="form-group">
<label>Caja</label>
<select name="caja_id" class="form-control">
@foreach($cajas as $caja)
<option value="{{ $caja->id }}">{{ $caja->nombre }}</option>
@endforeach
</select>
</div>

<div class="form-group">
<label>Monto apertura</label>

<div class="input-group">
    <div class="input-group-prepend">
        <span class="input-group-text">Gs.</span>
    </div>

    <input 
        type="text" 
        id="monto_apertura_formateado"
        class="form-control"
        placeholder="0"
        required>

    <input 
        type="hidden" 
        name="monto_apertura" 
        id="monto_apertura">
</div>

</div>

<button class="btn btn-success">
Abrir Caja
</button>

</div>

</div>

</form>

</div>

@endsection

@section('footer')
    @include('adminlte::partials.footer.footer')
@endsection


{{-- 🔥 SCRIPT --}}
@section('js')
<script>

const inputVisible = document.getElementById('monto_apertura_formateado');
const inputHidden = document.getElementById('monto_apertura');

inputVisible.addEventListener('input', function(e){

    let valor = e.target.value.replace(/\D/g, ''); // solo números

    // guardar valor limpio
    inputHidden.value = valor;

    // formatear miles
    e.target.value = valor.replace(/\B(?=(\d{3})+(?!\d))/g, ".");

});

</script>
@endsection
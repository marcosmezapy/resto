@extends('adminlte::page')

@section('title','POS Directo')

@section('content')

<div class="container-fluid">

<h3 class="mb-3">Venta Directa</h3>

@livewire('ventas.pos-venta',['venta_id'=>$venta->id])

</div>

@endsection
@section('footer')
    @include('adminlte::partials.footer.footer')
@endsection

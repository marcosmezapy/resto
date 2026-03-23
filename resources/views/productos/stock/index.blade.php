@extends('adminlte::page')

@section('title', 'Stock')

@section('content_header')
<h1>Stock</h1>
@stop

@section('content')
<div class="row">
    <div class="col-12">
        @livewire('productos.stock') <!-- Livewire solo dentro del controlador -->
    </div>
</div>
@stop
@section('footer')
    @include('adminlte::partials.footer.footer')
@endsection

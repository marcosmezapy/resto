@extends('adminlte::page')

@section('title','Compras')

@section('content_header')
    <h1>Compras</h1>
@stop

@section('content')
<div class="container">
    <livewire:compras.compra-index />
</div>
@endsection
@section('footer')
    @include('adminlte::partials.footer.footer')
@endsection

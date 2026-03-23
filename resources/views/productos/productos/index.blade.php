@extends('adminlte::page')

@section('title', 'Productos')

@section('content_header')
<h1>Productos</h1>
@stop

@section('content')

<div class="row">
    
    @livewire('productos.crud-producto')

</div>

@stop
@section('footer')
    @include('adminlte::partials.footer.footer')
@endsection

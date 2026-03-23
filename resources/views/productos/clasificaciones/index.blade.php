@extends('adminlte::page')

@section('title', 'Clasificaciones')

@section('content_header')
<h1>Clasificaciones</h1>
@stop

@section('content')
<div class="row">
    <div class="col-12">
        @livewire('productos.clasificaciones')
    </div>
</div>
@stop
@section('footer')
    @include('adminlte::partials.footer.footer')
@endsection

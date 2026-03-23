@extends('adminlte::page')

@section('title', 'Depositos')

@section('content_header')
<h1>Depositos</h1>
@stop

@section('content')

<div class="row">

    <h1>Depósitos</h1>
    @livewire('productos.depositos')

</div>

@stop
@section('footer')
    @include('adminlte::partials.footer.footer')
@endsection

@extends('adminlte::page')

@section('content')

    <h2>Sucursales</h2>
    <livewire:sucursales.sucursal-index />

    <hr>

    <livewire:sucursales.punto-expedicion-index />

    <hr>

    <livewire:sucursales.timbrado-index />
    <hr>
    <livewire:sucursales.cajas-index />
@stop
@section('footer')
    @include('adminlte::partials.footer.footer')
@endsection

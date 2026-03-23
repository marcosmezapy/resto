@extends('adminlte::page')

@section('title','Reporte de Inventario')

@section('content')

<div class="container-fluid">

@livewire('reportes.reporte-margen')

</div>

@endsection
@section('footer')
    @include('adminlte::partials.footer.footer')
@endsection

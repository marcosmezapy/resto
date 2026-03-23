

@extends('adminlte::page')

@section('title','Reporte de Inventario')

@section('content')

<div class="container-fluid">

@livewire('reportes.reporte-tendencia')

</div>

@endsection
@section('footer')
    @include('adminlte::partials.footer.footer')
@endsection

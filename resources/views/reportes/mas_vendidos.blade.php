@extends('adminlte::page')

@section('title','Top productos vendidos')

@section('content')

<div class="container-fluid">

@livewire('reportes.reporte-mas-vendidos')

</div>

@endsection
@section('footer')
    @include('adminlte::partials.footer.footer')
@endsection

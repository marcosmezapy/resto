@extends('adminlte::page')

@section('title','Stock Critico')

@section('content')

<div class="container-fluid">

@livewire('reportes.reporte-ticket')

</div>

@endsection
@section('footer')
    @include('adminlte::partials.footer.footer')
@endsection

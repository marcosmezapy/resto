@extends('adminlte::page')

@section('title','Cajas')

@section('content_header')

<h1>Cajas</h1>

@stop

@section('content')

<div class="card">

<div class="card-header">

@can('ventas.cajas.create')
<a href="{{ route('ventas.cajas.create') }}" class="btn btn-primary float-right">
Nueva Caja
</a>
@endcan

</div>

<div class="card-body">

<livewire:ventas.cajas-table />

</div>

</div>

@stop
@section('footer')
    @include('adminlte::partials.footer.footer')
@endsection

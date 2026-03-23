@extends('adminlte::page')

@section('title','Mesa')

@section('content_header')

<h2>Mesa {{ $mesa->numero }}</h2>

@stop


@section('content')

<div class="card">

<div class="card-body">

<livewire:ventas.pos-venta :venta_id="$venta->id"/>

</div>

</div>

@stop
@section('footer')
    @include('adminlte::partials.footer.footer')
@endsection

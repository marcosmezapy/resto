@extends('adminlte::page')

@section('title', 'Stock del producto')

@section('content_header')

<div class="d-flex justify-content-between align-items-center">

    <h1>
        Stock del producto:
        <strong>{{ $producto->nombre }}</strong>
    </h1>

    <a href="{{ route('productos.productos.view') }}" class="btn btn-secondary">
        <i class="fas fa-arrow-left"></i> Volver
    </a>

</div>

@stop


@section('content')
<livewire:productos.stock-producto :producto_id="$producto->id" />
@stop
@section('footer')
    @include('adminlte::partials.footer.footer')
@endsection

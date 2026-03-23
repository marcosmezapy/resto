@extends('adminlte::page')

@section('title','POS')

@section('content')

<div class="container-fluid pt-3">

<a href="{{ route('ventas.pos.directa.crear') }}" class="btn btn-success mb-4">
Nueva Venta Directa
</a>

<livewire:ventas.pos-mesas />

</div>

@endsection
@section('footer')
    @include('adminlte::partials.footer.footer')
@endsection

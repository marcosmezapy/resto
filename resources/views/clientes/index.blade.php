@extends('adminlte::page')

@section('title','Clientes')

@section('content_header')
<h1>Clientes</h1>
@stop

@section('content')

<div class="card">

<div class="card-header">

@can('clientes.clientes.create')
<a href="{{ route('clientes.clientes.create') }}" class="btn btn-primary float-right">
Nuevo Cliente
</a>
@endcan

</div>

<div class="card-body">

<livewire:clientes.clientes-table />

</div>

</div>

@stop
@section('footer')
    @include('adminlte::partials.footer.footer')
@endsection

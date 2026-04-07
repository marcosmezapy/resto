@extends('adminlte::page')

@section('title','Nuevo Cliente')

@section('content')

@if(session('success'))
<div class="alert alert-success">
    {{ session('success') }}
</div>
@endif

@livewire('clientes.cliente-form')

@endsection
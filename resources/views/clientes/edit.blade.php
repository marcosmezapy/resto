@extends('adminlte::page')

@section('title','Editar Cliente')

@section('content')

@if(session('success'))
<div class="alert alert-success">
    {{ session('success') }}
</div>
@endif

@livewire('clientes.cliente-form', ['clienteId' => $id])

@endsection
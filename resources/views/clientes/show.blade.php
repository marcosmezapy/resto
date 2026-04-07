@extends('adminlte::page')

@section('content')

@livewire('clientes.cliente-ficha',['id'=>$id])

@endsection
@extends('adminlte::page')

@section('title','Detalle de Venta')

@section('content')

@livewire('ventas.venta-detalle-historico',['ventaId'=>$id])

@endsection
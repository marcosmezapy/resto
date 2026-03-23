@extends('adminlte::page')

@section('title','Mesas')

@section('content_header')
<h1>Mesas</h1>
@stop

@section('content')

<div class="card">

<div class="card-header">

<a href="{{ route('mesas.mesas.create') }}" class="btn btn-primary float-right">
Nueva Mesa
</a>

</div>

<div class="card-body">

<livewire:mesas.mesas-table />

</div>

</div>

@stop
@section('footer')
    @include('adminlte::partials.footer.footer')
@endsection

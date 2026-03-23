@extends('adminlte::page')

@section('title','Empresa')

@section('content_header')
<h1>Empresa</h1>
@stop

@section('content')

<div class="content">


@livewire('empresa.crud-empresa')

</div>

@stop
@section('footer')
    @include('adminlte::partials.footer.footer')
@endsection

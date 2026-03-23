@extends('adminlte::page')

@section('title', 'Roles')

@section('content_header')
<h1>Roles</h1>
@stop

@section('content')

<div class="row">

    <div class="col-md-8">
        @livewire('administrador.roles')
    </div>

    <div class="col-md-4">
        @livewire('administrador.roles-form')
    </div>

</div>

@stop
@section('footer')
    @include('adminlte::partials.footer.footer')
@endsection

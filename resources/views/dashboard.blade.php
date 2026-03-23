@extends('adminlte::page')

@section('title','Dashboard')

@section('content')

<div class="container-fluid">

@livewire('reportes.dashboard-ejecutivo')

</div>


@endsection
@section('footer')
    @include('adminlte::partials.footer.footer')
@endsection

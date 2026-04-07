@extends('adminlte::page')

@section('title','Dashboard')

@section('content')

<div class="container-fluid">
@canany(['superadmin','reportes.index'])
  @livewire('reportes.dashboard-ejecutivo')
@else
    <!-- LO VE EL RESTO -->
    <p>Bienvenido al sistema ADMIRA</p>  
@endcanany

</div>


@endsection
@section('footer')
    @include('adminlte::partials.footer.footer')
@endsection

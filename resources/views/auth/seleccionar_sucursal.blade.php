@extends('adminlte::page')
@section('title','Seleccionar sucursal')

<div class="d-flex justify-content-center align-items-center vh-100" style="background: #f4f6f9;">

    <div class="card shadow-sm border-0" style="width: 420px; border-radius: 8px;">

        <!-- HEADER -->
        <div class="card-header bg-white border-bottom text-center py-4">
            <h5 class="mb-1 font-weight-bold text-dark">Seleccionar sucursal</h5>
            <small class="text-muted">Acceso al entorno de trabajo</small>
        </div>

        <!-- BODY -->
        <div class="card-body px-4 py-4">

            <form method="POST" action="{{ route('seleccionar.sucursal.store') }}">
                @csrf

                <!-- SELECT -->
                <div class="form-group mb-4">
                    <label class="text-muted small mb-1">Sucursal</label>

                    <select id="sucursalSelect" name="sucursal_id" class="form-control" required style="height: 45px;">
                        <option value="">Seleccionar...</option>

                        @foreach($sucursales as $sucursal)
                            <option value="{{ $sucursal->id }}">
                                {{ $sucursal->nombre }}
                            </option>
                        @endforeach

                    </select>
                </div>

                <!-- BUTTON -->
                <button id="btnIngresar"
                        type="submit" 
                        class="btn btn-dark btn-block"
                        style="height: 45px; font-weight: 500; border-radius: 6px;"
                        disabled>
                    Ingresar
                </button>

            </form>

        </div>

    </div>

</div>

<script>
    document.addEventListener('DOMContentLoaded', function () {
        const select = document.getElementById('sucursalSelect');
        const button = document.getElementById('btnIngresar');

        select.addEventListener('change', function () {
            button.disabled = !this.value;
        });
    });
</script>
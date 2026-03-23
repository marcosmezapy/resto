@extends('adminlte::page')

@section('title','Cerrar Caja')

@section('content_header')

<h1>Cierre de Caja</h1>
<div class="mb-3">

    <h5 class="mb-1">
        Caja: <strong>{{ $caja->caja->nombre ?? 'N/A' }}</strong>
    </h5>

    <small class="text-muted">
        Aperturada el 
        {{ \Carbon\Carbon::parse($caja->fecha_apertura)->format('d/m/Y H:i') }}
        por 
        <strong>{{ $caja->usuario->name ?? 'Usuario' }}</strong>
    </small>

</div>
@stop


@section('content')


<div class="row">

    <div class="col-md-6">
        <div class="card">

            <div class="card-header">
            <b>Ventas del Turno</b>
            </div>


            <div class="card-body">
                <table class="table table-bordered">
                    <tr>
                        <td>Ventas en Efectivo</td>
                        <td class="text-right">
                            Gs. {{ number_format($efectivo,0,',','.') }}
                        </td>
                    </tr>
                    <tr>
                        <td>Ventas con Tarjeta</td>
                        <td class="text-right">
                            Gs. {{ number_format($tarjeta,0,',','.') }}
                        </td>
                    </tr>
                    <tr>
                        <td>Ventas por Transferencia</td>
                        <td class="text-right">
                        Gs. {{ number_format($transferencia,0,',','.') }}
                        </td>
                    </tr>
                    <tr class="table-secondary">
                        <td>Total Ventas</td>
                        <td class="text-right">
                        Gs. {{ number_format($totalVentas,0,',','.') }}
                        </td>
                    </tr>
                </table>
            </div>
        </div>
    </div>

    <div class="col-md-6">
        <div class="card">

            <div class="card-header">
                <b>Flujo de Caja</b>
            </div>

            <div class="card-body">


                <table class="table table-bordered">
                    <tr>
                        <td>Apertura de Caja</td>
                        <td class="text-right">
                        Gs. {{ number_format($caja->monto_apertura,0,',','.') }}
                        </td>
                    </tr>
                    <tr>
                        <td>Ventas en Efectivo</td>
                        <td class="text-right">
                        Gs. {{ number_format($efectivo,0,',','.') }}
                        </td>
                    </tr>
                    <tr>
                        <td>Ingresos Manuales</td>
                        <td class="text-right">
                        Gs. {{ number_format($ingresos,0,',','.') }}
                        </td>
                    </tr>
                    <tr>
                        <td>Gastos</td>
                        <td class="text-right text-danger">
                        - Gs. {{ number_format($gastos,0,',','.') }}
                        </td>
                    </tr>
                    <tr>
                        <td>Retiros</td>
                        <td class="text-right text-danger">
                        - Gs. {{ number_format($retiros,0,',','.') }}
                        </td>
                    </tr>
                    <tr class="table-success">
                        <td><b>Total Esperado en Caja</b></td>
                        <td class="text-right">
                        <b>Gs. {{ number_format($totalEsperado,0,',','.') }}</b>
                        </td>
                    </tr>
                </table>
            </div>
        </div>
    </div>


    <div class="col-md-6">
        <div class="card">
            <div class="card-header">
                <b>Detalle de Movimientos de Caja</b>
            </div>

            <div class="card-body">

            @if($movimientos->count())

                <table class="table table-sm table-bordered">
                    <thead class="table-light">
                        <tr>
                            <th>Tipo</th>
                            <th>Descripción</th>
                            <th>Monto</th>
                            <th>Fecha</th>
                        </tr>
                    </thead>
                <tbody>
                    @foreach($movimientos as $mov)
                    <tr>
                        <td>
                            @if($mov->tipo=='ingreso')
                                <span class="badge bg-success">Ingreso</span>
                            @endif
                            @if($mov->tipo=='gasto')
                                <span class="badge bg-danger">Gasto</span>
                            @endif
                            @if($mov->tipo=='retiro')
                                <span class="badge bg-warning">Retiro</span>
                            @endif
                        </td>
                        <td>{{ $mov->descripcion }}</td>
                        <td>
                        Gs. {{ number_format($mov->monto,0,',','.') }}
                        </td>
                        <td>
                        {{ \Carbon\Carbon::parse($mov->created_at)->format('d/m/Y H:i') }}
                        </td>

                    </tr>
                    @endforeach

                </tbody>

                </table>

            @else
                <div class="alert alert-info">
                No hay movimientos registrados
                </div>

            @endif

            </div>
        </div>
    </div>
 
    <div class="col-md-6">
        <div class="card">
            <div class="card-header">
                <b>Confirmar Cierre</b>
            </div>
            <div class="card-body">
                <form method="POST"
                action="{{ route('ventas.cajas.cerrar.store') }}">
                @csrf
                <input
                type="hidden"
                name="caja_id"
                value="{{ $caja->id }}">
                <label>Monto contado (efectivo) en caja</label>
                <input
                type="number"
                name="monto_contado"
                class="form-control"
                required>
                <br>
                <button
                class="btn btn-danger btn-block">
                Cerrar Caja
                </button>
                </form>
            </div>
        </div>
    </div>


</div>


</div>


@stop
@section('footer')
    @include('adminlte::partials.footer.footer')
@endsection

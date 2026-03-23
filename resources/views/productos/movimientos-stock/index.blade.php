@extends('adminlte::page')

@section('title', 'Movimientos de Stock')

@section('content_header')
<h1>Movimientos de Stock</h1>
@stop

@section('content')

<div class="card">
    <div class="card-body">

        <table class="table table-bordered table-striped">

            <thead class="table-dark">
                <tr>
                    <th>Producto</th>
                    <th>Depósito</th>
                    <th>Tipo</th>
                    <th>Cantidad</th>
                    <th>Lote</th>
                    <th>Costo</th>
                    <th>Fecha</th>
                </tr>
            </thead>

            <tbody>

                @forelse($movimientos as $m)

                <tr>
                    <td>{{ $m->producto->nombre }}</td>
                    <td>{{ $m->deposito->nombre }}</td>

                    <td>
                        @if($m->tipo == 'entrada')
                            <span class="badge bg-success">Entrada</span>
                        @elseif($m->tipo == 'salida')
                            <span class="badge bg-danger">Salida</span>
                        @elseif($m->tipo == 'transferencia')
                            <span class="badge bg-warning">Transferencia</span>
                        @else
                            <span class="badge bg-secondary">Ajuste</span>
                        @endif
                    </td>

                    <td>{{ $m->cantidad }}</td>
                    <td>{{ $m->lote }}</td>
                    <td>{{ number_format($m->costo_unitario,0,',','.') }}</td>
                    <td>{{ $m->created_at->format('d/m/Y H:i') }}</td>

                </tr>

                @empty

                <tr>
                    <td colspan="7" class="text-center">
                        No existen movimientos registrados
                    </td>
                </tr>

                @endforelse

            </tbody>

        </table>

        <div class="mt-3">
            {{ $movimientos->links() }}
        </div>

    </div>
</div>

@stop
@section('footer')
    @include('adminlte::partials.footer.footer')
@endsection

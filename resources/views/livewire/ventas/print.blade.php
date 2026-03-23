<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>Comprobante</title>

    <style>
        body{
            font-family: monospace;
            font-size: 12px;
        }

        .center{text-align:center;}
        .right{text-align:right;}
        .bold{font-weight:bold;}

        table{
            width:100%;
            border-collapse:collapse;
        }

        td{
            padding:2px 0;
        }

        hr{
            border:none;
            border-top:1px dashed #000;
            margin:5px 0;
        }
    </style>
</head>

<body onload="window.print()">

<div class="center bold">
    {{ $venta->tenant->nombre ?? 'EMPRESA' }}
</div>

<div class="center">
    RUC: {{ $venta->tenant->ruc ?? '-' }} <br>
    {{ $venta->sucursal->nombre ?? '' }}
</div>

<hr>

@if($venta->tipo_documento == 'factura')
    <div class="center bold">FACTURA</div>
    N°: {{ $venta->numero_documento }} <br>
    Timbrado: {{ $venta->timbrado->numero_timbrado ?? '' }} <br>
@endif

@if($venta->tipo_documento == 'ticket')
    <div class="center bold">TICKET</div>
    N°: {{ $venta->numero_documento }}
@endif

<hr>

Fecha: {{ $venta->created_at->format('d/m/Y H:i') }} <br>
Cajero: {{ $venta->usuario->name ?? '' }} <br>
Cliente: {{ $venta->cliente->nombre ?? 'Consumidor Final' }}

<hr>

<table>
@foreach($venta->detalles as $d)
<tr>
    <td>
        {{ $d->producto->nombre }} <br>
        {{ $d->cantidad }} x {{ number_format($d->precio,0,',','.') }}
    </td>
    <td class="right">
        {{ number_format($d->subtotal,0,',','.') }}
    </td>
</tr>
@endforeach
</table>

<hr>

@if($venta->tipo_documento == 'factura')
    IVA 10%: {{ number_format($venta->total_gravada_10,0,',','.') }} <br>
    IVA 5%: {{ number_format($venta->total_gravada_5,0,',','.') }} <br>
@endif

<div class="bold right">
    TOTAL: {{ number_format($venta->total,0,',','.') }}
</div>

<hr>

<div class="center">
    ¡Gracias por su compra!
</div>

</body>
</html>
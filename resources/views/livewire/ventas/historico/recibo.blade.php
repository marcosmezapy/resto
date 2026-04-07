<!DOCTYPE html>
<html>
<head>
<meta charset="utf-8">
<title>Recibo de Cobro</title>

<style>
body {
    font-family: Arial, sans-serif;
    font-size: 12px;
}
.header {
    text-align: center;
    margin-bottom: 10px;
}
.box {
    border: 1px solid #000;
    padding: 10px;
    margin-bottom: 10px;
}
</style>

</head>

<body onload="window.print()">

@if($pago->venta->estado == 'cancelada')
<div style="
    text-align:center;
    font-weight:bold;
    font-size:18px;
    border:2px solid;
    padding:5px;
    margin-bottom:10px;
">
    *** DOCUMENTO CANCELADO ***
</div>
@endif


<div class="header">
<h3>RECIBO DE COBRO</h3>
</div>

<div class="box">

<b>Cliente:</b> {{ $pago->venta->cliente->nombre ?? 'Consumidor Final' }} <br>
<b>RUC:</b> {{ $pago->venta->cliente->ruc ?? '-' }} <br>

<b>Documento:</b> {{ ucfirst($pago->venta->tipo_documento) }} <br>
<b>N°:</b> {{ $pago->venta->numero_documento }} <br>

<b>Fecha:</b> {{ now()->format('d/m/Y H:i') }} <br>

</div>

<div class="box">

<b>Método:</b> {{ ucfirst($pago->metodo_pago) }} <br>
<b>Monto:</b> Gs {{ number_format($pago->monto,0,',','.') }} <br>

@if($pago->referencia)
<b>Referencia:</b> {{ $pago->referencia }} <br>
@endif

<b>Cajero:</b> {{ $pago->user->name ?? '-' }}

</div>

<div class="box">

<b>Saldo restante:</b> 
Gs {{ number_format($pago->venta->saldo,0,',','.') }}

</div>

<br><br>

<div style="text-align:center">
----------------------------<br>
Firma / Aclaración
</div>

</body>
</html>
<form method="POST" action="{{ route('ventas.pos.pagar.store',$venta->id) }}">
@csrf

<h4>Total: {{ number_format($venta->total,0,',','.') }}</h4>

<div class="form-group">
<label>Efectivo</label>
<input type="number" name="pagos[0][monto]" class="form-control">
<input type="hidden" name="pagos[0][metodo_pago]" value="efectivo">
</div>

<div class="form-group">
<label>Tarjeta</label>
<input type="number" name="pagos[1][monto]" class="form-control">
<input type="hidden" name="pagos[1][metodo_pago]" value="tarjeta">
</div>

<div class="form-group">
<label>Transferencia</label>
<input type="number" name="pagos[2][monto]" class="form-control">
<input type="hidden" name="pagos[2][metodo_pago]" value="transferencia">
</div>

<button class="btn btn-success">
Confirmar Pago
</button>

</form>
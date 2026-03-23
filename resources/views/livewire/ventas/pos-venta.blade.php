<div>

{{-- CLIENTE --}}
<div class="row mt-2">

<div class="col-md-12">

<div class="card">

<div class="card-body p-2">

<input
type="text"
class="form-control form-control-sm"
placeholder="Buscar cliente por nombre o RUC..."
wire:model.live="buscarCliente">

@if($clienteSeleccionado)

<div class="alert alert-success mt-1 p-1 small">

Cliente:
<strong>{{ $clienteNombre }}</strong>

<button
class="btn btn-sm btn-danger float-right py-0 px-2"
wire:click="limpiarCliente">

X

</button>

</div>

@endif


@if(count($resultadosClientes))

<div class="cliente-resultados mt-1">

@foreach($resultadosClientes as $cliente)

<div
class="cliente-item"
wire:click="seleccionarCliente({{ $cliente->id }})">

<strong>{{ $cliente->nombre }}</strong>

@if($cliente->ruc)
<br>
<small>RUC: {{ $cliente->ruc }}</small>
@endif

</div>

@endforeach

</div>

@endif

</div>

</div>

</div>

</div>



{{-- BUSCADOR PRODUCTO --}}
<div class="row mt-2">

<div class="col-md-12">

<input
type="text"
class="form-control buscador-pos"
placeholder="Escanear código o buscar producto..."
wire:model.live="buscarProducto"
autocomplete="off">

</div>

</div>



<div class="row mt-2">

{{-- CATEGORIAS --}}
<div class="col-md-3">

<div class="card">

<div class="card-header p-2">
<b>Categorías</b>
</div>

<div class="card-body p-1">

@foreach($clasificaciones as $clasificacion)

<button
wire:click="seleccionarClasificacion({{ $clasificacion->id }})"

class="btn btn-sm btn-block mb-1
@if($buscarProducto)
btn-secondary
@else
btn-light border
@endif"

@if($buscarProducto)
disabled
@endif
>

{{ $clasificacion->nombre }}

</button>

@endforeach

</div>

</div>

</div>



{{-- PRODUCTOS --}}
<div class="col-md-5">

<div class="card">

<div class="card-header p-2">
<b>Productos</b>
</div>

<div class="card-body p-2">

<div class="row">

@foreach($productos as $producto)

<div class="col-md-6 mb-2">

<div
wire:click="agregarProducto({{ $producto->id }})"
class="producto-card">

<div class="producto-nombre">
{{ $producto->nombre }}
</div>

<div class="producto-precio">
Gs. {{ number_format($producto->precio_venta,0,',','.') }}
</div>

</div>

</div>

@endforeach

</div>

</div>

</div>

</div>



{{-- VENTA --}}
<div class="col-md-4">

<div class="card">

<div class="card-header p-2">
<b>Venta</b>
</div>

<div class="card-body p-2">

<table class="table table-sm mb-1">

<thead>
<tr>
<th>Producto</th>
<th width="100">Cant</th>
<th width="30"></th>
</tr>
</thead>

<tbody>

@foreach($detalles as $detalle)

<tr>

<td class="small">{{ $detalle->producto->nombre }}</td>

<td>

<button
wire:click="restar({{ $detalle->id }})"
class="btn btn-outline-secondary btn-sm py-0 px-2">-</button>

<span class="mx-1 small">{{ $detalle->cantidad }}</span>

<button
wire:click="agregarProducto({{ $detalle->producto_id }})"
class="btn btn-outline-secondary btn-sm py-0 px-2">+</button>

</td>

<td>

<button
wire:click="eliminar({{ $detalle->id }})"
class="btn btn-danger btn-sm py-0 px-2">X</button>

</td>

</tr>

@endforeach

</tbody>

</table>


<hr class="my-1">

<div class="total-box">

Total

<span>
Gs. {{ number_format($venta->total,0,',','.') }}
</span>

</div>


<button
class="btn btn-dark btn-sm btn-block mt-2"
data-toggle="modal"
data-target="#modalPago">

COBRAR

</button>

</div>

</div>

</div>

</div>



{{-- MODAL COBRAR --}}
<div class="modal fade" id="modalPago" wire:ignore.self>

<div class="modal-dialog modal-lg">

<div class="modal-content">

<div class="modal-header p-2">

<h5 class="modal-title">Cobrar Venta</h5>

<button type="button" class="close" data-dismiss="modal">
<span>&times;</span>
</button>

</div>


<div class="modal-body">
    @php
    $tenant = \App\Models\Tenant::find($venta->tenant_id);
@endphp

@if($tenant->tipo_facturacion == 'formal')

<div class="row mb-2">
    <div class="col-md-12">

        <label><b>Tipo de Documento</b></label>

        <select class="form-control form-control-sm"
                wire:model="tipo_documento">

            <option value="factura">Factura</option>
            <option value="ticket">Ticket</option>

        </select>

    </div>
</div>

@endif

<div class="row">

<div class="col-md-6">

<h4>Total</h4>

<h3>
Gs. {{ number_format($venta->total,0,',','.') }}
</h3>



</div>


<div class="col-md-6">

<div class="alert alert-secondary p-2">

Restante:

<strong>
Gs. {{ number_format($this->restante,0,',','.') }}
</strong>

</div>

</div>

</div>


<hr>


@foreach($pagos as $index => $pago)

<div class="row pago-row mb-1" wire:key="pago-{{ $index }}">

<div class="col-md-5">

<select
class="form-control form-control-sm"
wire:model.live="pagos.{{ $index }}.metodo_pago">

<option value="efectivo">Efectivo</option>
<option value="tarjeta">Tarjeta</option>
<option value="transferencia">Transferencia</option>

</select>

</div>

<div class="col-md-5">

<div class="input-group input-group-sm">

    <div class="input-group-prepend">
        <span class="input-group-text">Gs.</span>
    </div>

    <input 
        type="text"
        class="form-control form-control-sm monto-formateado"
        data-index="{{ $index }}"
        id="monto_visible_{{ $index }}"
        placeholder="0">

    <input 
        type="hidden"
        wire:model.live="pagos.{{ $index }}.monto"
        id="monto_hidden_{{ $index }}">

</div>

</div>

<div class="col-md-2 text-right">

    @if($index > 0)

    <button
    type="button"
    class="btn btn-danger btn-sm py-0 px-2"
    wire:click="eliminarPago({{ $index }})">

    X

    </button>

    @endif

</div>

</div>

@endforeach


<button
type="button"
class="btn btn-sm btn-outline-secondary mt-1"
wire:click="agregarPago">

Agregar pago

</button>


<hr class="my-2">


<div class="alert alert-info p-2">

    Vuelto:

    <strong>
    Gs. {{ number_format($this->vuelto,0,',','.') }}
    </strong>

</div>

</div>


<div class="modal-footer p-2">

    <button
    type="button"
    class="btn btn-success btn-sm"
    wire:click="cobrar"
    @if($this->restante > 0) disabled @endif>

    Confirmar Pago

    </button>

</div>

</div>

</div>

</div>



<style>

    .buscador-pos{
    font-size:18px;
    height:40px;
    }

    .producto-card{
    background:#fff;
    border:1px solid #ddd;
    border-radius:5px;
    padding:10px;
    cursor:pointer;
    height:70px;

    display:flex;
    flex-direction:column;
    justify-content:center;
    }

    .producto-card:hover{
    border-color:#888;
    box-shadow:0 1px 4px rgba(0,0,0,0.1);
    }

    .producto-nombre{
    font-weight:600;
    font-size:14px;
    }

    .producto-precio{
    color:#666;
    font-size:13px;
    }

    .total-box{
    display:flex;
    justify-content:space-between;
    font-size:18px;
    font-weight:bold;
    }

    .cliente-resultados{
    border:1px solid #ddd;
    border-radius:4px;
    max-height:150px;
    overflow-y:auto;
    background:white;
    }

    .cliente-item{
    padding:6px;
    cursor:pointer;
    border-bottom:1px solid #eee;
    font-size:14px;
    }

    .cliente-item:hover{
    background:#f5f5f5;
    }

</style>


<script>

    window.addEventListener('errorStock', () => {

    alert('Stock insuficiente');

    })

    window.addEventListener('errorPagoIncompleto', () => {

    alert('El pago no cubre el total de la cuenta.');

    })

</script>
{{-- es algo del comprobante --}}
<script>
    window.addEventListener('printVenta', event => {

        let printUrl = "{{ url('/ventas') }}/" + event.detail.ventaId + "/print";
        let posUrl = "{{ route('ventas.pos.index') }}";

        let win = window.open(printUrl, '_blank');

        if(win){
            win.focus();
        } else {
            alert("El navegador bloqueó la ventana emergente");
        }

        setTimeout(() => {
            window.location.href = posUrl;
        }, 1000);

    });
</script>



<script>

// 🔥 FORMATEAR MILES
function formatear(valor){
    return (valor || '').toString().replace(/\B(?=(\d{3})+(?!\d))/g, ".");
}


// 🔥 INPUT MANUAL (ESCRITURA)
document.addEventListener('input', function(e){

    if(e.target.classList.contains('monto-formateado')){

        let valor = e.target.value.replace(/\D/g, '');
        let index = e.target.dataset.index;

        // actualizar hidden (Livewire)
        let hidden = document.getElementById('monto_hidden_' + index);

        if(hidden){
            hidden.value = valor;
            hidden.dispatchEvent(new Event('input')); // 🔥 clave para Livewire
        }

        // formatear visual
        e.target.value = formatear(valor);
    }

});


// 🔥 SINCRONIZAR (PARA PAGAR TOTAL)
function syncMontos(){

    document.querySelectorAll('[id^="monto_hidden_"]').forEach(function(hidden){

        let index = hidden.id.replace('monto_hidden_', '');
        let visible = document.getElementById('monto_visible_' + index);

        if(visible){
            let valor = hidden.value || '';
            visible.value = formatear(valor);
        }

    });

}

</script>   


</div>
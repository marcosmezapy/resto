<?php

namespace App\Livewire\Ventas;

use Livewire\Component;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;

use App\Models\Venta;
use App\Models\VentaDetalle;
use App\Models\VentaPago;
use App\Models\PrdProducto;
use App\Models\PrdClasificacion;
use App\Models\Cliente;
use App\Models\PrdMovimientoStock;
use App\Models\PrdStock;
use App\Models\VentaDetalleLote;
use App\Services\StockService; // <-- AGREGADO

class PosVenta extends Component
{

public $venta;

public $clasificaciones;

public $productos = [];

public $detalles = [];

public $buscarProducto = '';

public $clasificacionSeleccionada = null;

public $pagos = [];

public $buscarCliente = '';

public $resultadosClientes = [];

public $clienteSeleccionado = null;

public $clienteNombre = 'Consumidor Final';



public function mount($venta_id)
{

$this->venta = Venta::findOrFail($venta_id);

if($this->venta->cliente_id){

$cliente = Cliente::find($this->venta->cliente_id);

if($cliente){

$this->clienteSeleccionado = $cliente->id;

$this->clienteNombre = $cliente->nombre;

}

}

$this->clasificaciones = PrdClasificacion::orderBy('nombre')->get();

$this->cargarProductos();

$this->cargarDetalles();

$this->pagos = [
[
'metodo_pago'=>'efectivo',
'monto'=>0
]
];

}



/* =================================
CLIENTES
================================= */

public function updatedBuscarCliente()
{

if(strlen($this->buscarCliente) < 2){

$this->resultadosClientes = [];

return;

}

$this->resultadosClientes = Cliente::where('nombre','like','%'.$this->buscarCliente.'%')
->orWhere('ruc','like','%'.$this->buscarCliente.'%')
->limit(10)
->get();

}



public function seleccionarCliente($cliente_id)
{

$cliente = Cliente::findOrFail($cliente_id);

$this->venta->cliente_id = $cliente->id;
$this->venta->save();

$this->clienteSeleccionado = $cliente->id;
$this->clienteNombre = $cliente->nombre;

$this->buscarCliente = '';
$this->resultadosClientes = [];

}



public function limpiarCliente()
{

$this->venta->cliente_id = null;
$this->venta->save();

$this->clienteSeleccionado = null;
$this->clienteNombre = 'Consumidor Final';

}



/* =================================
PRODUCTOS
================================= */

public function seleccionarClasificacion($id)
{

$this->clasificacionSeleccionada = $id;

$this->buscarProducto = '';

$this->cargarProductos();

}



public function cargarProductos()
{

$query = PrdProducto::query();

if($this->clasificacionSeleccionada){
$query->where('clasificacion_id',$this->clasificacionSeleccionada);
}

if($this->buscarProducto){
$query->where('nombre','like','%'.$this->buscarProducto.'%');
}

$this->productos = $query->limit(30)->get();

}


public function updatedBuscarProducto()
{

$this->cargarProductos();

}



/* =================================
DETALLES
================================= */

    public function cargarDetalles()
    {

    $this->detalles = VentaDetalle::with('producto')
    ->where('venta_id',$this->venta->id)
    ->get();

    }




    public function agregarProducto($producto_id)
    {

    $producto = PrdProducto::findOrFail($producto_id);

    /* VALIDAR STOCK */
    if($producto->es_stockeable){

    $stockDisponible = PrdStock::where('producto_id',$producto->id)
        ->where('sucursal_id', session('sucursal_id')) // 🔥
        ->sum('cantidad');

    $detalleActual = VentaDetalle::where('venta_id',$this->venta->id)
    ->where('producto_id',$producto_id)
    ->first();

    $cantidadEnVenta = $detalleActual ? $detalleActual->cantidad : 0;

    if(($cantidadEnVenta + 1) > $stockDisponible){

    $this->dispatch('errorStock');

    return;

    }

    }

    $precio = $producto->precio_venta;

    // 🆕 OBTENER IVA DEL PRODUCTO
    $ivaPorcentaje = $producto->ivaTipo->porcentaje ?? 0;

    // 🆕 CALCULAR IVA UNITARIO (precio YA incluye IVA)
    if($ivaPorcentaje == 10){
        $ivaUnitario = $precio / 11;
    }elseif($ivaPorcentaje == 5){
        $ivaUnitario = $precio / 21;
    }else{
        $ivaUnitario = 0;
    }


    $detalle = VentaDetalle::where('venta_id',$this->venta->id)
    ->where('producto_id',$producto_id)
    ->first();

    if(!$detalle){

    VentaDetalle::create([
    'venta_id'=>$this->venta->id,
    'producto_id'=>$producto_id,
    'cantidad'=>1,
    'precio'=>$precio,
    'subtotal'=>$precio,
        // 🆕 IVA
    'iva_porcentaje'=>$ivaPorcentaje,
    'iva_unitario'=>$ivaUnitario,
    'iva_total'=>$ivaUnitario // cantidad = 1
    ]);

    }else{

    $detalle->cantidad += 1;
    $detalle->subtotal = $detalle->cantidad * $detalle->precio;
    // 🆕 recalcular IVA total
    $detalle->iva_total = $detalle->cantidad * $detalle->iva_unitario;
    $detalle->save();

    }

    $this->actualizarVenta();

    }



public function restar($detalle_id)
{

$detalle = VentaDetalle::findOrFail($detalle_id);

if($detalle->cantidad <= 1){

$this->eliminar($detalle_id);

return;

}

$detalle->cantidad -= 1;

$detalle->subtotal = $detalle->cantidad * $detalle->precio;
$detalle->iva_total = $detalle->cantidad * $detalle->iva_unitario;

$detalle->save();

$this->actualizarVenta();

}



public function eliminar($detalle_id)
{

VentaDetalle::findOrFail($detalle_id)->delete();

$this->actualizarVenta();

}



public function actualizarVenta()
{

$detalles = VentaDetalle::where('venta_id',$this->venta->id)->get();

$total = $detalles->sum('subtotal');

// 🆕 TOTAL IVA
$totalIva = $detalles->sum('iva_total');

// 🆕 AGRUPACIONES
$total10 = $detalles->where('iva_porcentaje',10)->sum('subtotal');
$total5 = $detalles->where('iva_porcentaje',5)->sum('subtotal');
$totalExenta = $detalles->where('iva_porcentaje',0)->sum('subtotal');;


if($detalles->count() == 0){

$this->venta->update([
    'estado' => 'cancelada',
    'total' => 0
]);

$this->venta = null;

return redirect()->route('ventas.pos.index');

}

$this->venta->update([
    'total'=>$total,

    // 🆕 IVA
    'total_iva'=>$totalIva,
    'total_gravada_10'=>$total10,
    'total_gravada_5'=>$total5,
    'total_exenta'=>$totalExenta
]);

$this->venta = Venta::find($this->venta->id);

$this->cargarDetalles();

$this->cargarProductos();

}



/* =================================
PROCESAR STOCK FIFO
================================= */
    public function procesarStockVenta()
    {

        $detalles = VentaDetalle::where('venta_id',$this->venta->id)->get();

        foreach($detalles as $detalle){

        $producto = PrdProducto::find($detalle->producto_id);

        if(!$producto || !$producto->es_stockeable){
            $detalle->costo_unitario = $producto->costo_base ?? 0; 
            $detalle->save();

            continue;
        }

        $cantidadPendiente = $detalle->cantidad;

         $costoTotal = 0; // 🆕 AGREGADO

        /* FIFO */

    $stocks = PrdStock::where('producto_id',$detalle->producto_id)
        ->where('sucursal_id', session('sucursal_id')) // 🔥
        ->where('cantidad','>',0)
        ->orderBy('fecha_ingreso','asc')
        ->get();

        foreach($stocks as $stock){

        if($cantidadPendiente <= 0){
        break;
        }

        $usar = min($stock->cantidad,$cantidadPendiente);

        /* GUARDAR LOTE USADO */

        VentaDetalleLote::create([
        'venta_detalle_id'=>$detalle->id,
        'stock_id'=>$stock->id,
        'cantidad'=>$usar,
        'costo_unitario'=>$stock->costo_compra
        ]);

        /* 🆕 ACUMULAR COSTO */
        $costoTotal += ($usar * $stock->costo_compra);

        /* DESCONTAR STOCK */

        $stock->cantidad -= $usar;
        $stock->save();

        /* MOVIMIENTO STOCK */

        PrdMovimientoStock::create([
        'producto_id'=>$detalle->producto_id,
        'stock_id'=>$stock->id,
        'tipo'=>'salida',
        'cantidad'=>$usar,
        'referencia'=>'venta',
        'deposito_id' => $stock->deposito_id,
        'referencia_id'=>$this->venta->id,
        'costo_unitario'=>$stock->costo_compra
        ]);

        $cantidadPendiente -= $usar;

        }

        /* ================================
        🆕 AGREGADO: GUARDAR COSTO PROMEDIO
        ================================ */
        if($detalle->cantidad > 0){
            $detalle->costo_unitario = $costoTotal / $detalle->cantidad;
            $detalle->save();
        }
        
        }

    }



/* =================================
PAGOS
================================= */

public function agregarPago()
{

$this->pagos[] = [
'metodo_pago'=>'efectivo',
'monto'=>0
];

}



public function eliminarPago($index)
{

unset($this->pagos[$index]);

$this->pagos = array_values($this->pagos);

}



public function getTotalPagadoProperty()
{

$total = 0;

foreach($this->pagos as $pago){

$total += floatval($pago['monto']);

}

return $total;

}



public function getRestanteProperty()
{

$restante = $this->venta->total - $this->totalPagado;

return $restante > 0 ? $restante : 0;

}



public function getVueltoProperty()
{

$vuelto = $this->totalPagado - $this->venta->total;

return $vuelto > 0 ? $vuelto : 0;

}



public function cobrar()
{
    if($this->restante > 0){
        $this->dispatch('errorPagoIncompleto');
        return;
    }

    DB::transaction(function(){

        $venta = Venta::with('cajaSesion.caja')
            ->lockForUpdate()
            ->find($this->venta->id);

        /*
        =====================================
        1. REGISTRAR PAGOS
        =====================================
        */
        foreach($this->pagos as $pago){

            if(floatval($pago['monto']) > 0){

                VentaPago::create([
                    'venta_id'=>$venta->id,
                    'metodo_pago'=>$pago['metodo_pago'],
                    'monto'=>floatval($pago['monto'])
                ]);

            }
        }

        /*
        =====================================
        2. PROCESAR STOCK
        =====================================
        */
        $this->venta = $venta;
        $this->procesarStockVenta();

        /*
        =====================================
        3. OBTENER CAJA → PUNTO
        =====================================
        */
        $caja = $venta->cajaSesion->caja;

        if(!$caja->punto_expedicion_id){
            throw new \Exception("La caja no tiene punto de expedición asignado");
        }

        /*
        =====================================
        4. NUMERACIÓN (LOCK)
        =====================================
        */
        $numeracion = \App\Models\Numeracion::where('tenant_id',$venta->tenant_id)
            ->where('sucursal_id',$venta->sucursal_id)
            ->where('punto_expedicion_id',$caja->punto_expedicion_id)
            ->lockForUpdate()
            ->first();

        if(!$numeracion){
            throw new \Exception("No existe numeración configurada");
        }

        $nuevoNumero = $numeracion->ultimo_numero + 1;

        /*
        =====================================
        5. TIMBRADO
        =====================================
        */
        $timbrado = \App\Models\Timbrado::where('tenant_id',$venta->tenant_id)
            ->where('sucursal_id',$venta->sucursal_id)
            ->where('punto_expedicion_id',$caja->punto_expedicion_id)
            ->where('estado','vigente')
            ->first();

        if(!$timbrado){
            throw new \Exception("No hay timbrado vigente");
        }

        /*
        =====================================
        🚨 VALIDAR RANGO TIMBRADO
        =====================================
        */
        if($nuevoNumero > $timbrado->numero_fin){
            throw new \Exception("Timbrado agotado");
        }

        /*
        =====================================
        6. FORMATEAR FACTURA (PRO)
        =====================================
        */

        // 🟢 OBTENER CÓDIGOS REALES
        $sucursal = \App\Models\Sucursal::find($venta->sucursal_id);
        $punto = \App\Models\PuntoExpedicion::find($caja->punto_expedicion_id);

        $codigoSucursal = str_pad($sucursal->codigo ?? $venta->sucursal_id, 3, '0', STR_PAD_LEFT);
        $codigoPunto = str_pad($punto->codigo ?? $caja->punto_expedicion_id, 3, '0', STR_PAD_LEFT);
        $numeroFormateado = str_pad($nuevoNumero, 7, '0', STR_PAD_LEFT);

        $numeroFactura = "{$codigoSucursal}-{$codigoPunto}-{$numeroFormateado}";

        /*
        =====================================
        7. ACTUALIZAR NUMERACIÓN
        =====================================
        */
        $numeracion->update([
            'ultimo_numero'=>$nuevoNumero
        ]);
        $timbrado->update([
            'ultimo_numero_usado' => $nuevoNumero
        ]);
        /*
        =====================================
        8. ACTUALIZAR VENTA
        =====================================
        */
        $venta->update([
            'estado'=>'pagada',
            'punto_expedicion_id'=>$caja->punto_expedicion_id,
            'timbrado_id'=>$timbrado->id,
            'numero'=>$nuevoNumero,
            'numero_factura'=>$numeroFactura
        ]);

    });

    return redirect()->route('ventas.pos.index');
}



public function pagarTotal()
{

if(count($this->pagos) == 0){

$this->pagos[] = [
'metodo_pago' => 'efectivo',
'monto' => $this->venta->total
];

return;

}

$this->pagos[0]['monto'] = $this->venta->total;

}




public function render()
{

return view('livewire.ventas.pos-venta');

}

}
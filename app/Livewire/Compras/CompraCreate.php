<?php

namespace App\Livewire\Compras;


use App\Models\Compra;
use App\Models\CompraDetalle;
use Livewire\Component;
use App\Models\PrdProducto;
use App\Models\Proveedor;
use App\Models\Depositos; // 🔥 IMPORTANTE
use App\Models\PrdDeposito;
use App\Services\StockService;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class CompraCreate extends Component
{
    public $proveedor_id;
    public $numero_factura;
    public $fecha;
    public $deposito_id; // 🔥 NUEVO

    public $items = [];

    protected $listeners = ['crearCompra' => 'init'];

    public function init()
    {
        $this->reset();
        $this->fecha = now()->format('Y-m-d');
        $this->agregarItem();
    }

    public function agregarItem()
    {
        $this->items[] = [
            'producto_id' => '',
            'cantidad' => 1,
            'precio' => 0,
            'subtotal' => 0,
        ];
    }

    public function eliminarItem($index)
    {
        unset($this->items[$index]);
        $this->items = array_values($this->items);
    }

    // 🔥 FIX SUBTOTAL
    public function updatedItems()
    {
        foreach ($this->items as $i => $item) {
            $this->items[$i]['subtotal'] =
                (float)($item['cantidad'] ?? 0) * (float)($item['precio'] ?? 0);
        }
    }

    public function getTotalProperty()
    {
        return collect($this->items)->sum('subtotal');
    }

    public function guardar()
    {
        $this->validate([
            'proveedor_id' => 'required',
            'fecha' => 'required',
            'deposito_id' => 'required', // 🔥 CLAVE
        ]);

        DB::beginTransaction();

        try {
            $tenantId = Auth::user()->tenant_id;
            $sucursalId = session('sucursal_id');

            $compra = Compra::create([
                'tenant_id' => $tenantId,
                'sucursal_id' => $sucursalId,
                'proveedor_id' => $this->proveedor_id,
                'numero_factura' => $this->numero_factura,
                'fecha' => $this->fecha,
                'total' => $this->total,
                'estado' => 'confirmado'
            ]);

            foreach ($this->items as $item) {

                if (!$item['producto_id']) continue;

                $producto = PrdProducto::find($item['producto_id']);

                if (!$producto || !$producto->es_stockeable) continue;

                CompraDetalle::create([
                    'compra_id' => $compra->id,
                    'producto_id' => $item['producto_id'],
                    'cantidad' => $item['cantidad'],
                    'precio' => $item['precio'],
                    'subtotal' => $item['subtotal'],
                ]);

                // 🔥 STOCK CON DEPÓSITO SELECCIONADO
                StockService::ingresarStock(
                    producto_id: $item['producto_id'],
                    cantidad: $item['cantidad'],
                    sucursal_id: $sucursalId,
                    tenant_id: $tenantId,
                    costo_compra: $item['precio'], // 🔥 CLAVE
                    deposito_id: $this->deposito_id,
                    motivo: 'compra',
                    referencia_id: $compra->id,
                    fecha_ingreso: $this->fecha, // 🔥 USA FECHA DE FACTURA
                );
            }

            DB::commit();

            $this->reset();

        } catch (\Exception $e) {
            DB::rollBack();
            throw $e;
        }
    }

    public function resetear()
    {
        $this->reset();
    }

    public function render()
    {
        $tenantId = Auth::user()->tenant_id;
        $sucursalId = session('sucursal_id');

        $productos = PrdProducto::where('tenant_id', $tenantId)
            ->where('es_stockeable', 1)
            ->get();

        $proveedores = Proveedor::all();

        // 🔥 DEPÓSITOS POR SUCURSAL
        $depositos = PrdDeposito::where('sucursal_id', $sucursalId)->get();

        return view('livewire.compras.create', compact('proveedores', 'productos', 'depositos'));
    }
}
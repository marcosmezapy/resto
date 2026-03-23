<?php
/*
namespace App\Livewire\Productos;

use Livewire\Component;
use App\Models\PrdStock;
use App\Models\PrdDeposito;
use App\Models\PrdMovimientoStock;
use App\Models\PrdProducto;

class StockProducto extends Component
{
    public $producto_id;
    public $producto;
    public $depositos;
    public $stocks;

    public $deposito_id;
    public $lote;
    public $fecha_ingreso;
    public $cantidad;
    public $costo_compra;

    public $showForm = false;

    public function mount($producto_id)
    {
        $this->producto_id = $producto_id;
        $this->producto = PrdProducto::findOrFail($producto_id);
        $this->depositos = PrdDeposito::all();
        $this->stocks = $this->producto->stocks;
    }

    public function toggleForm()
    {
        $this->showForm = !$this->showForm;
    }

    public function resetInputFields()
    {
        $this->deposito_id = '';
        $this->lote = '';
        $this->fecha_ingreso = '';
        $this->cantidad = '';
        $this->costo_compra = '';
        $this->showForm = false;
    }

public function addStock()
{
    $this->validate([
        'deposito_id' => 'required',
        'lote' => 'required',
        'fecha_ingreso' => 'required|date',
        'cantidad' => 'required|numeric|min:1',
        'costo_compra' => 'required|numeric|min:0',
    ]);

    $stock = PrdStock::create([
        'producto_id' => $this->producto_id,
        'deposito_id' => $this->deposito_id,
        'lote' => $this->lote,
        'fecha_ingreso' => $this->fecha_ingreso,
        'cantidad' => $this->cantidad,
        'costo_compra' => $this->costo_compra,
    ]);

    // Registrar movimiento
    PrdMovimientoStock::create([
        'producto_id' => $this->producto_id,
        'deposito_id' => $this->deposito_id,
        'tipo' => 'entrada',
        'cantidad' => $this->cantidad,
        'costo_unitario' => $this->costo_compra,
        'lote' => $this->lote,
        'descripcion' => 'Ingreso de stock desde producto'
    ]);

    session()->flash('message', 'Stock agregado correctamente.');

    $this->resetInputFields();

    $this->stocks = $this->producto->stocks()->get();
}

    public function render()
    {
        return view('livewire.productos.stock-producto');
    }
}*/


namespace App\Livewire\Productos;

use Livewire\Component;
use App\Models\PrdStock;
use App\Models\PrdDeposito;
use App\Models\PrdMovimientoStock;
use App\Models\PrdProducto;
use App\Models\Proveedor;

class StockProducto extends Component
{
    public $producto_id;
    public $producto;
    public $depositos;
    public $stocks;
    public $proveedores; // 👈 NUEVO

    public $deposito_id;
    public $proveedor_id; // 👈 NUEVO
    public $lote;
    public $fecha_ingreso;
    public $cantidad;
    public $costo_compra;

    public $showForm = false;

    public function mount($producto_id)
    {
        $this->producto_id = $producto_id;
        $this->producto = PrdProducto::where('es_stockeable', 1)->findOrFail($producto_id);
        $this->depositos = PrdDeposito::all();
        $this->proveedores = Proveedor::orderBy('nombre')->get(); // 👈 NUEVO
        $this->stocks = $this->producto->stocks;
    }

    public function toggleForm()
    {
        $this->showForm = !$this->showForm;
    }

    public function resetInputFields()
    {
        $this->deposito_id = '';
        $this->proveedor_id = ''; // 👈 NUEVO
        $this->lote = '';
        $this->fecha_ingreso = '';
        $this->cantidad = '';
        $this->costo_compra = '';
        $this->showForm = false;
    }

    public function addStock()
    {
        $this->validate([
            'deposito_id' => 'required',
            'proveedor_id' => 'nullable|exists:proveedores,id', // 👈 NUEVO
            'lote' => 'required',
            'fecha_ingreso' => 'required|date',
            'cantidad' => 'required|numeric|min:1',
            'costo_compra' => 'required|numeric|min:0',
        ]);

        $stock = PrdStock::create([
            'producto_id' => $this->producto_id,
            'deposito_id' => $this->deposito_id,
            'proveedor_id' => $this->proveedor_id, // 👈 NUEVO
            'lote' => $this->lote,
            'fecha_ingreso' => $this->fecha_ingreso,
            'cantidad' => $this->cantidad,
            'costo_compra' => $this->costo_compra,
        ]);

        // Movimiento
        PrdMovimientoStock::create([
            'producto_id' => $this->producto_id,
            'deposito_id' => $this->deposito_id,
            'tipo' => 'entrada',
            'cantidad' => $this->cantidad,
            'costo_unitario' => $this->costo_compra,
            'lote' => $this->lote,
            'descripcion' => 'Ingreso de stock desde producto (Proveedor ID: ' . $this->proveedor_id . ')'
        ]);

        session()->flash('message', 'Stock agregado correctamente.');

        $this->resetInputFields();

        $this->stocks = $this->producto->stocks()->with('proveedor')->get();
    }

    public function render()
    {
        return view('livewire.productos.stock-producto');
    }
}
<?php
/*
namespace App\Livewire\Productos;

use Livewire\Component;
use App\Models\PrdStock;
use App\Models\PrdProducto;
use App\Models\PrdDeposito;
use App\Models\PrdMovimientoStock;

class Stock extends Component
{
    public $producto_id;
    public $deposito_id;
    public $lote;
    public $fecha_ingreso;
    public $cantidad;
    public $costo_compra;
    public $stock_id;

    public $showForm = false;
    public $stocks;
    public $productos;
    public $depositos;

    public function mount()
    {
        $this->loadStock();
        $this->loadProductos();
        $this->loadDepositos();
    }

    public function loadStock()
    {
        $this->stocks = PrdStock::with(['producto', 'deposito'])->orderBy('id', 'desc')->get();
    }

    public function loadProductos()
    {
        $this->productos = PrdProducto::orderBy('nombre')->get();
    }

    public function loadDepositos()
    {
        $this->depositos = PrdDeposito::orderBy('nombre')->get();
    }

    public function toggleForm()
    {
        $this->resetInputFields();
        $this->showForm = !$this->showForm;
    }

    public function resetInputFields()
    {
        $this->producto_id = null;
        $this->deposito_id = null;
        $this->lote = '';
        $this->fecha_ingreso = '';
        $this->cantidad = '';
        $this->costo_compra = '';
        $this->stock_id = null;
    }

public function store()
{
    $this->validate([
        'producto_id' => 'required|exists:prd_productos,id',
        'deposito_id' => 'required|exists:prd_depositos,id',
        'lote' => 'required|string|max:255',
        'fecha_ingreso' => 'required|date',
        'cantidad' => 'required|integer|min:1',
        'costo_compra' => 'required|numeric|min:0',
    ]);

    $stock = PrdStock::updateOrCreate(
        [
            'producto_id' => $this->producto_id,
            'deposito_id' => $this->deposito_id,
            'lote' => $this->lote
        ],
        [
            'fecha_ingreso' => $this->fecha_ingreso,
            'cantidad' => $this->cantidad,
            'costo_compra' => $this->costo_compra,
        ]
    );

    // Registrar movimiento
    PrdMovimientoStock::create([
        'producto_id' => $this->producto_id,
        'deposito_id' => $this->deposito_id,
        'tipo' => 'entrada',
        'cantidad' => $this->cantidad,
        'costo_unitario' => $this->costo_compra,
        'lote' => $this->lote,
        'descripcion' => 'Ingreso de stock'
    ]);

    session()->flash('message','Stock agregado correctamente.');

    $this->resetInputFields();
    $this->showForm = false;

    $this->loadStock();
}

    public function edit($id)
    {
        $stock = PrdStock::findOrFail($id);
        $this->stock_id = $id;
        $this->producto_id = $stock->producto_id;
        $this->deposito_id = $stock->deposito_id;
        $this->lote = $stock->lote;
        $this->fecha_ingreso = $stock->fecha_ingreso;
        $this->cantidad = $stock->cantidad;
        $this->costo_compra = $stock->costo_compra;
        $this->showForm = true;
    }

    public function delete($id)
    {
        $stock = PrdStock::findOrFail($id);
        $stock->delete();
        session()->flash('message', 'Stock eliminado correctamente.');
        $this->loadStock();
    }

    public function render()
    {
        return view('livewire.productos.stock');
    }
}*/



namespace App\Livewire\Productos;

use Livewire\Component;
use App\Models\PrdStock;
use App\Models\PrdProducto;
use App\Models\PrdDeposito;
use App\Models\PrdMovimientoStock;
use App\Models\Proveedor;

class Stock extends Component
{
    public $producto_id;
    public $deposito_id;
    public $proveedor_id; // 👈 NUEVO
    public $lote;
    public $fecha_ingreso;
    public $cantidad;
    public $costo_compra;
    public $stock_id;

    public $showForm = false;
    public $stocks;
    public $productos;
    public $depositos;
    public $proveedores; // 👈 NUEVO

    public function mount()
    {
        $this->loadStock();
        $this->loadProductos();
        $this->loadDepositos();
        $this->loadProveedores(); // 👈 NUEVO
    }

    public function loadStock()
    {
        $this->stocks = PrdStock::with(['producto', 'deposito', 'proveedor'])
            ->orderBy('id', 'desc')
            ->get();
    }

    public function loadProductos()
    {
        $this->productos = PrdProducto::where('es_stockeable', 1)
            ->orderBy('nombre')
            ->get();
    }

    public function loadDepositos()
    {
        $this->depositos = PrdDeposito::orderBy('nombre')->get();
    }

    public function loadProveedores()
    {
        $this->proveedores = Proveedor::orderBy('nombre')->get();
    }

    public function toggleForm()
    {
        $this->resetInputFields();
        $this->showForm = !$this->showForm;
    }

    public function resetInputFields()
    {
        $this->producto_id = null;
        $this->deposito_id = null;
        $this->proveedor_id = null; // 👈 NUEVO
        $this->lote = '';
        $this->fecha_ingreso = '';
        $this->cantidad = '';
        $this->costo_compra = '';
        $this->stock_id = null;
    }

    public function store()
    {
        $this->validate([
            'producto_id' => 'required|exists:prd_productos,id',
            'deposito_id' => 'required|exists:prd_depositos,id',
            'proveedor_id' => 'nullable|exists:proveedores,id', // 👈 NUEVO
            'lote' => 'required|string|max:255',
            'fecha_ingreso' => 'required|date',
            'cantidad' => 'required|integer|min:1',
            'costo_compra' => 'required|numeric|min:0',
        ]);

        $stock = PrdStock::updateOrCreate(
            [
                'producto_id' => $this->producto_id,
                'deposito_id' => $this->deposito_id,
                'lote' => $this->lote
            ],
            [
                'proveedor_id' => $this->proveedor_id, // 👈 NUEVO
                'fecha_ingreso' => $this->fecha_ingreso,
                'cantidad' => $this->cantidad,
                'costo_compra' => $this->costo_compra,
            ]
        );

        // Movimiento
        PrdMovimientoStock::create([
            'producto_id' => $this->producto_id,
            'deposito_id' => $this->deposito_id,
            'tipo' => 'entrada',
            'cantidad' => $this->cantidad,
            'costo_unitario' => $this->costo_compra,
            'lote' => $this->lote,
            'descripcion' => 'Ingreso de stock (Proveedor ID: ' . $this->proveedor_id . ')'
        ]);

        session()->flash('message','Stock agregado correctamente.');

        $this->resetInputFields();
        $this->showForm = false;

        $this->loadStock();
    }

    public function edit($id)
    {
        $stock = PrdStock::findOrFail($id);
        $this->stock_id = $id;
        $this->producto_id = $stock->producto_id;
        $this->deposito_id = $stock->deposito_id;
        $this->proveedor_id = $stock->proveedor_id; // 👈 NUEVO
        $this->lote = $stock->lote;
        $this->fecha_ingreso = $stock->fecha_ingreso;
        $this->cantidad = $stock->cantidad;
        $this->costo_compra = $stock->costo_compra;
        $this->showForm = true;
    }

    public function delete($id)
    {
        $stock = PrdStock::findOrFail($id);
        $stock->delete();
        session()->flash('message', 'Stock eliminado correctamente.');
        $this->loadStock();
    }

    public function render()
    {
        return view('livewire.productos.stock');
    }
}
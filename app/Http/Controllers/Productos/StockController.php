<?php

namespace App\Http\Controllers\Productos;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\PrdStock;
use App\Models\PrdProducto;
use App\Models\PrdDeposito;

class StockController extends Controller
{
    public function index()
    {
        // Renderiza la vista Livewire general
        return view('productos.stock.index');
    }

    public function create()
    {
        $productos = PrdProducto::orderBy('nombre')->get();
        $depositos = PrdDeposito::where('sucursal_id', session('sucursal_id'))
        ->orderBy('nombre')
        ->get();
        return view('productos.stock.create', compact('productos','depositos'));
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'producto_id' => 'required|exists:prd_productos,id',
            'deposito_id' => 'required|exists:prd_depositos,id',
            'lote' => 'required|string|max:255',
            'fecha_ingreso' => 'required|date',
            'cantidad' => 'required|integer|min:1',
            'costo_compra' => 'required|numeric|min:0',
            'costo_venta' => 'required|numeric|min:0',
        ]);

        $deposito = PrdDeposito::findOrFail($request->deposito_id);

        if ($deposito->sucursal_id != session('sucursal_id')) {
            abort(403, 'Depósito inválido para esta sucursal');
        }

        $data['sucursal_id'] = session('sucursal_id');

        PrdStock::create($data);
        return redirect()->route('productos.stock.view')->with('message','Stock agregado correctamente.');
    }

    public function edit($id)
    {
        $stock = PrdStock::findOrFail($id);
        $productos = PrdProducto::orderBy('nombre')->get();
        $depositos = PrdDeposito::orderBy('nombre')->get();

        return view('productos.stock.edit', compact('stock','productos','depositos'));
    }

    public function update(Request $request, $id)
    {
        $data = $request->validate([
            'producto_id' => 'required|exists:prd_productos,id',
            'deposito_id' => 'required|exists:prd_depositos,id',
            'lote' => 'required|string|max:255',
            'fecha_ingreso' => 'required|date',
            'cantidad' => 'required|integer|min:1',
            'costo_compra' => 'required|numeric|min:0',
            'costo_venta' => 'required|numeric|min:0',
        ]);

        PrdStock::findOrFail($id)->update($data);
        return redirect()->route('productos.stock.view')->with('message','Stock actualizado correctamente.');
    }

    public function destroy($id)
    {
        PrdStock::findOrFail($id)->delete();
        return redirect()->route('productos.stock.view')->with('message','Stock eliminado correctamente.');
    }
}
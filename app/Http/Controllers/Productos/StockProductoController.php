<?php

namespace App\Http\Controllers\Productos;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\PrdProducto;
use App\Models\PrdStock;
use App\Models\PrdDeposito;

class StockProductoController extends Controller
{
    public function index($producto_id)
    {
        $producto = PrdProducto::findOrFail($producto_id);
        return view('productos.stock.stock-producto', compact('producto'));
    }

    public function store(Request $request, $producto_id)
    {
        $request->validate([
            'deposito_id' => 'required|exists:prd_depositos,id',
            'lote' => 'required|string|max:255',
            'fecha_ingreso' => 'required|date',
            'cantidad' => 'required|integer|min:1',
            'costo_compra' => 'required|numeric|min:0',
            'costo_venta' => 'required|numeric|min:0',
        ]);

        PrdStock::create(array_merge($request->all(), ['producto_id'=>$producto_id]));
        return redirect()->route('productos.producto.stock.view', $producto_id)
                         ->with('message','Stock agregado correctamente.');
    }
}
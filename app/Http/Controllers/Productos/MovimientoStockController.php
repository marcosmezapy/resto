<?php

namespace App\Http\Controllers\Productos;

use App\Http\Controllers\Controller;
use App\Models\PrdMovimientoStock;

class MovimientoStockController extends Controller
{
    public function index()
    {
        $movimientos = PrdMovimientoStock::with('producto','deposito')
                        ->latest()
                        ->paginate(20);

        return view('productos.movimientos-stock.index',compact('movimientos'));
    }
}
<?php
namespace App\Http\Controllers\Productos;

use App\Http\Controllers\Controller;

class DepositoController extends Controller
{
    public function index()
    {
        return view('productos.depositos.index');
    }
}
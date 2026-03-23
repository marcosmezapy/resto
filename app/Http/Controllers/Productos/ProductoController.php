<?php
namespace App\Http\Controllers\Productos;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class ProductoController extends Controller
{
    public function __construct()
    {
        $this->middleware('can:productos.productos.index')->only('index');
        $this->middleware('can:productos.productos.create')->only('create','store');
        $this->middleware('can:productos.productos.edit')->only('edit','update');
        $this->middleware('can:productos.productos.delete')->only('destroy');
    }

    public function index()
    {
        return view('productos.productos.index');
    }

    public function create()
    {
     //   return view('productos.productos.create');
    }

    public function edit($id)
    {
      //  return view('productos.productos.edit', compact('id'));
    }
}
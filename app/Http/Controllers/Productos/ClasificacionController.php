<?php

namespace App\Http\Controllers\Productos;

use App\Http\Controllers\Controller;

class ClasificacionController extends Controller
{
    public function index()
    {
        return view('productos.clasificaciones.index');
    }
}
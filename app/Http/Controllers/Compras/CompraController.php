<?php

namespace App\Http\Controllers\Compras;

use App\Http\Controllers\Controller;

class CompraController extends Controller
{
    public function index()
    {
        return view('compras.index');
    }
}
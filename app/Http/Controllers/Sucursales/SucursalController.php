<?php

namespace App\Http\Controllers\Sucursales;

use App\Http\Controllers\Controller;

class SucursalController extends Controller
{
    public function index()
    {
        return view('sucursales.index');
    }
}
<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;

class RoleController extends Controller
{

    public function __construct()
    {
        $this->middleware('permission:administrador.roles.index')->only('index');
    }

    public function index()
    {
        return view('administrador.roles.index');
    }
}
<?php

namespace App\Http\Controllers\Clientes;

use App\Http\Controllers\Controller;
use App\Models\Cliente;
use Illuminate\Http\Request;

class ClienteController extends Controller
{

/*
    public function __construct()
    {
        $this->middleware('permission:clientes.clientes.index')->only('index');
        $this->middleware('permission:clientes.clientes.create')->only(['create','store']);
        $this->middleware('permission:clientes.clientes.edit')->only(['edit','update']);
        $this->middleware('permission:clientes.clientes.delete')->only('destroy');
    }
*/


    public function index()
    {
        return view('clientes.index');
    }

    public function create()
    {
        return view('clientes.create');
    }

    public function edit($id)
    {
        return view('clientes.edit', compact('id'));
    }

    public function show($id)
    {
        return view('clientes.show', compact('id'));
    }


}
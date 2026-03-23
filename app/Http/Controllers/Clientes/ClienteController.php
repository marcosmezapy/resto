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

    public function store(Request $request)
    {

        $request->validate([
            'nombre'=>'required|max:255'
        ]);

        Cliente::create($request->all());

        return redirect()
            ->route('clientes.clientes.view')
            ->with('success','Cliente creado correctamente');
    }

    public function edit(Cliente $cliente)
    {
        return view('clientes.edit', compact('cliente'));
    }

    public function update(Request $request, Cliente $cliente)
    {

        $request->validate([
            'nombre'=>'required|max:255'
        ]);

        $cliente->update($request->all());

        return redirect()
            ->route('clientes.clientes.view')
            ->with('success','Cliente actualizado');
    }

    public function destroy(Cliente $cliente)
    {
        $cliente->delete();

        return redirect()
            ->route('clientes.clientes.view')
            ->with('success','Cliente eliminado');
    }
}
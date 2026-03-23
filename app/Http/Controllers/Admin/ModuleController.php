<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Module;

class ModuleController extends Controller
{
    public function __construct()
    {
        // Middleware de permisos usando Spatie
        $this->middleware('permission:administrador.modulos.index')->only('index');
        $this->middleware('permission:administrador.modulos.create')->only(['create','store']);
        $this->middleware('permission:administrador.modulos.edit')->only(['edit','update']);
        $this->middleware('permission:administrador.modulos.delete')->only('destroy');
    }

    public function index()
    {
        $modules = Module::all();
        return view('administrador.modulos.index', compact('modules'));
    }

    public function create()
    {
        return view('administrador.modulos.create');
    }

    public function store(Request $request)
    {
        //dd($request->all()); // <-- VER QUE LLEGA EL REQUEST

        $request->validate([
            'name' => 'required|string|max:255|unique:modules,name',
            'active' => 'nullable' // quitar |boolean
        ]);

        $module = Module::create([
            'name' => $request->name,
            'active' => $request->has('active') ? 1 : 0
        ]);

        //dd($module);

        return redirect()->route('administrador.modulos.view')
                         ->with('success', 'Módulo creado.');
    }

    public function edit(Module $module)
    {
        return view('administrador.modulos.edit', compact('module'));
    }

    public function update(Request $request, Module $module)
    {
        $request->validate([
            'name' => "required|string|max:255|unique:modules,name,{$module->id}",
            'active' => 'nullable|boolean'
        ]);

        $module->update([
            'name' => $request->name,
            'active' => $request->has('active')
        ]);

        return redirect()->route('administrador.modulos.view')
                         ->with('success', 'Módulo actualizado.');
    }

    public function destroy(Module $module)
    {
        $module->delete();

        return redirect()->route('administrador.modulos.view')
                         ->with('success', 'Módulo eliminado.');
    }
}
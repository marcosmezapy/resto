<?php

namespace App\Http\Controllers\Restaurante;

use App\Http\Controllers\Controller;
use App\Models\Mesa;
use Illuminate\Http\Request;

class MesaController extends Controller
{

    public function __construct()
    {
        $this->middleware('permission:mesas.mesas.index')->only('index');
        $this->middleware('permission:mesas.mesas.create')->only(['create','store']);
        $this->middleware('permission:mesas.mesas.edit')->only(['edit','update']);
        $this->middleware('permission:mesas.mesas.delete')->only('destroy');
    }

    public function index()
    {
        return view('mesas.index');
    }

    public function create()
    {
        return view('mesas.create');
    }

    public function store(Request $request)
    {
        
        $request->validate([
            'numero' => 'required|max:100',
            'capacidad' => 'nullable|integer|min:1'
        ]);

        $data = [
            'numero' => $request->numero,
            'capacidad' => $request->capacidad,
            'tenant_id' => session('tenant_id'),
            'sucursal_id' => session('sucursal_id'), // 🔥 OBLIGATORIO
        ];

        Mesa::create($data);

        return redirect()
            ->route('mesas.mesas.view')
            ->with('success','Mesa creada correctamente');
    }

    public function edit(Mesa $mesa)
    {
        return view('mesas.edit',compact('mesa'));
    }

    public function update(Request $request, Mesa $mesa)
    {

        $request->validate([
            'numero'=>'required|max:100'
        ]);

        $mesa->update($request->all());

        return redirect()
            ->route('mesas.mesas.view')
            ->with('success','Mesa actualizada');
    }

    public function destroy(Mesa $mesa)
    {

        $mesa->delete();

        return redirect()
            ->route('mesas.mesas.view')
            ->with('success','Mesa eliminada');
    }
}
<?php

namespace App\Http\Controllers\Ventas;

use App\Http\Controllers\Controller;
use App\Models\Caja;
use Illuminate\Http\Request;

class CajaController extends Controller
{

    public function __construct()
    {
        $this->middleware('permission:ventas.cajas.index')->only('index');
        $this->middleware('permission:ventas.cajas.create')->only(['create','store']);
        $this->middleware('permission:ventas.cajas.edit')->only(['edit','update']);
        $this->middleware('permission:ventas.cajas.delete')->only('destroy');
    }

    public function index()
    {
        return view('ventas.cajas.index');
    }

    public function create()
    {
        return view('ventas.cajas.create');
    }

    public function store(Request $request)
    {

        $request->validate([
            'nombre' => 'required|max:255'
        ]);

        $data = $request->all();

        $data['activa'] = $request->has('activa');

        Caja::create($data);

        return redirect()
            ->route('ventas.cajas.view')
            ->with('success','Caja creada correctamente');

    }

    public function edit(Caja $caja)
    {
        return view('ventas.cajas.edit',compact('caja'));
    }

    public function update(Request $request, Caja $caja)
    {

        $request->validate([
            'nombre' => 'required|max:255'
        ]);

        $data = $request->all();

        $data['activa'] = $request->has('activa');

        $caja->update($data);

        return redirect()
            ->route('ventas.cajas.view')
            ->with('success','Caja actualizada');

    }

    public function destroy(Caja $caja)
    {

        $caja->delete();

        return redirect()
            ->route('ventas.cajas.view')
            ->with('success','Caja eliminada');

    }

}
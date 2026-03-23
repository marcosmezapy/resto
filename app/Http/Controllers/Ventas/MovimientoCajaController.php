<?php

namespace App\Http\Controllers\Ventas;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\CajaSesion;
use App\Models\MovimientoCaja;
use Illuminate\Support\Facades\Auth;

class MovimientoCajaController extends Controller
{

    public function create()
    {

    $cajaSesion = CajaSesion::where('usuario_id',Auth::id())
        ->where('estado','abierta')
        ->where('sucursal_id', session('sucursal_id')) // 🔥
        ->first();

        if(!$cajaSesion){

            return redirect()
                ->route('ventas.cajas.view')
                ->with('error','No tienes caja abierta.');

        }

        return view('ventas.movimientos.create',compact('cajaSesion'));
    }

    public function store(Request $request)
    {

        $request->validate([

            'tipo' => 'required',
            'monto' => 'required|numeric|min:0'

        ]);

        $cajaSesion = CajaSesion::where('usuario_id',Auth::id())
            ->where('estado','abierta')
            ->first();

        if(!$cajaSesion){

            return back()->with('error','No hay caja abierta.');

        }

        MovimientoCaja::create([

            'caja_sesion_id' => $cajaSesion->id,
            'tipo' => $request->tipo,
            'descripcion' => $request->descripcion,
            'monto' => $request->monto

        ]);

        return redirect()
            ->route('ventas.cajas.view')
            ->with('success','Movimiento registrado');

    }

}
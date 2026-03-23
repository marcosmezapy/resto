<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class SucursalSeleccionController extends Controller
{
    public function index()
    {
        $user = Auth::user();

        $sucursales = $user->sucursales()
            ->wherePivot('activo', true)
            ->get();

        return view('auth.seleccionar_sucursal', compact('sucursales'));
    }

    public function seleccionar(Request $request)
    {
        $request->validate([
            'sucursal_id' => 'required|exists:sucursales,id'
        ]);

        $user = Auth::user();

        $sucursal = $user->sucursales()
            ->where('sucursal_id', $request->sucursal_id)
            ->first();

        if (!$sucursal) {
            abort(403);
        }

        session([
            'sucursal_id' => $sucursal->id,
            'sucursal_nombre' => $sucursal->nombre // 🔥 ESTE FALTABA
        ]);

        return redirect()->route('dashboard');
    }
}
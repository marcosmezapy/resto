<?php

namespace App\Http\Controllers\Ventas;

use App\Http\Controllers\Controller;
use App\Models\Mesa;
use App\Models\Venta;
use App\Models\CajaSesion;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class PosController extends Controller
{

    public function index()
    {

        return view('ventas.pos.index');

    }


    public function mesa($mesa_id)
    {

        $mesa = Mesa::findOrFail($mesa_id);

        $cajaSesion = CajaSesion::where('usuario_id', Auth::id())
            ->where('estado','abierta')
            ->where('sucursal_id', session('sucursal_id')) // 🔥 AGREGAR
            ->first();

        if(!$cajaSesion){

            return redirect()
                ->route('ventas.cajas.abrir')
                ->with('error','Debes abrir caja primero.');

        }


        /*
        ---------------------------------
        BLOQUEAR CONCURRENCIA DE MESAS
        ---------------------------------
        */

        $venta = DB::transaction(function() use ($mesa, $cajaSesion) {

            // buscar venta abierta en la mesa (sin importar la caja)
            $venta = Venta::where('mesa_id',$mesa->id)
                ->where('estado','abierta')
                ->lockForUpdate()
                ->first();

            // si existe usar esa
            if($venta){
                return $venta;
            }

            // si no existe crear
            $caja = $cajaSesion->caja;
            return Venta::create([

                'tipo_venta' => 'mesa',
                'caja_sesion_id' => $cajaSesion->id,
                'mesa_id' => $mesa->id,
                'usuario_id' => Auth::id(),
                'total' => 0,
                'estado' => 'abierta',
                    // 🔥 NUEVO (CRÍTICO)
                'sucursal_id' => $caja->sucursal_id

            ]);

        });


        return view(
            'ventas.pos.mesa',
            compact('mesa','venta')
        );

    }


    public function ventaDirecta()
    {

        $cajaSesion = CajaSesion::where('usuario_id',Auth::id())
            ->where('estado','abierta')
            ->where('sucursal_id', session('sucursal_id')) // 🔥 AGREGAR
            ->first();

        if(!$cajaSesion){

            return redirect()
                ->route('ventas.cajas.abrir')
                ->with('error','Debes abrir caja primero.');

        }
        $caja = $cajaSesion->caja;
        $venta = Venta::create([

            'tipo_venta' => 'directa',
            'caja_sesion_id' => $cajaSesion->id,
            'mesa_id' => null,
            'usuario_id' => Auth::id(),
            'total' => 0,
            'estado' => 'abierta',
            'sucursal_id' => $caja->sucursal_id


        ]);

        return redirect()->route('ventas.pos.directa',$venta->id);

    }

}
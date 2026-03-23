<?php

namespace App\Livewire\Ventas;

use Livewire\Component;
use App\Models\Mesa;
use App\Models\Venta;
use App\Models\CajaSesion;
use Illuminate\Support\Facades\Auth;
use Carbon\Carbon;

class PosMesas extends Component
{

    public function render()
    {

        $mesas = Mesa::where('sucursal_id', session('sucursal_id'))
        ->orderBy('numero')
        ->get();

        $caja = CajaSesion::where('usuario_id',Auth::id())
            ->where('estado','abierta')
            ->where('sucursal_id', session('sucursal_id')) // 🔥
            ->first();

        $ventas = collect();

        if($caja){

            $ventas = Venta::where('estado','abierta')
                ->where('caja_sesion_id',$caja->id)
                ->whereHas('detalles')
                ->get()
                ->keyBy('mesa_id');

        }

        foreach ($mesas as $mesa) {

            if(isset($ventas[$mesa->id])){

                $venta = $ventas[$mesa->id];

                $mesa->ocupada = true;

                $mesa->total = $venta->total;

                $inicio = Carbon::parse($venta->created_at);

                $mesa->tiempo = $inicio->diffForHumans(now(),[
                    'parts'=>2,
                    'syntax'=>Carbon::DIFF_ABSOLUTE
                ]);

            }else{

                $mesa->ocupada = false;
                $mesa->total = 0;
                $mesa->tiempo = null;

            }

        }

        return view('livewire.ventas.pos-mesas',[
            'mesas'=>$mesas
        ]);

    }

}
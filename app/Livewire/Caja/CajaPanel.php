<?php

namespace App\Livewire\Caja;

use Livewire\Component;
use Illuminate\Support\Facades\Auth;

use App\Models\MovimientoCaja;
use App\Models\CajaSesion;

class CajaPanel extends Component
{

public $tipo = 'gasto';
public $descripcion = '';
public $monto = '';

public $movimientos = [];

public function mount()
{
$this->cargarMovimientos();
}

public function cargarMovimientos()
{

$sesion = CajaSesion::where('estado','abierta')->first();

if(!$sesion){
$this->movimientos = [];
return;
}

$this->movimientos = MovimientoCaja::where('caja_sesion_id',$sesion->id)
->latest()
->take(20)
->get();

}

public function registrarMovimiento()
{

$sesion = CajaSesion::where('estado','abierta')->first();

if(!$sesion){
$this->dispatch('errorCaja');
return;
}

MovimientoCaja::create([
'caja_sesion_id'=>$sesion->id,
'user_id'=>Auth::id(),
'tipo'=>$this->tipo,
'descripcion'=>$this->descripcion,
'monto'=>$this->monto
]);

$this->reset(['descripcion','monto']);

$this->cargarMovimientos();

$this->dispatch('movimientoRegistrado');

}

public function render()
{
return view('livewire.caja.caja-panel');
}



}
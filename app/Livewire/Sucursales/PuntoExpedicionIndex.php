<?php

namespace App\Livewire\Sucursales;

use Livewire\Component;
use App\Models\PuntoExpedicion;
use App\Models\Sucursal;
use App\Models\Numeracion;

class PuntoExpedicionIndex extends Component
{
    public $puntos = [];
    public $sucursales = [];

    public $codigo;
    public $sucursal_id;

    public function mount()
    {
        $this->sucursales = Sucursal::where('tenant_id', tenant_id())->get();
        $this->cargar();
    }

    public function cargar()
    {
        $this->puntos = PuntoExpedicion::where('tenant_id', tenant_id())->get();
    }

    public function guardar()
    {
        $this->validate([
            'codigo' => 'required',
            'sucursal_id' => 'required'
        ]);

        $punto = PuntoExpedicion::create([
            'tenant_id' => tenant_id(),
            'sucursal_id' => $this->sucursal_id,
            'codigo' => $this->codigo
        ]);

        // 🔥 crear numeración automáticamente
        Numeracion::create([
            'tenant_id' => tenant_id(),
            'sucursal_id' => $this->sucursal_id,
            'punto_expedicion_id' => $punto->id,
            'ultimo_numero' => 0
        ]);

        $this->reset(['codigo','sucursal_id']);
        $this->cargar();
    }

    public function render()
    {
        return view('livewire.sucursales.puntos');
    }
}
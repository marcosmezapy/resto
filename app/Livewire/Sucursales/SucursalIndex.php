<?php

namespace App\Livewire\Sucursales;

use Livewire\Component;
use App\Models\Sucursal;

class SucursalIndex extends Component
{
    public $sucursales = [];

    public $codigo, $nombre, $direccion, $telefono, $email;

    public function mount()
    {
        $this->cargar();
    }

    public function cargar()
    {
        $this->sucursales = Sucursal::where('tenant_id', tenant_id())->get();
    }

    public function guardar()
    {
        $this->validate([
            'codigo' => 'required|digits:3',
            'nombre' => 'required'
        ]);

        Sucursal::create([
            'tenant_id' => tenant_id(),
            'codigo' => $this->codigo, // 🔥 NUEVO
            'nombre' => $this->nombre,
            'direccion' => $this->direccion,
            'telefono' => $this->telefono,
            'email' => $this->email,
            'activo' => 1
        ]);

        $this->reset(['codigo','nombre','direccion','telefono','email']);

        $this->cargar();
    }

    public function render()
    {
        return view('livewire.sucursales.index');
    }
}
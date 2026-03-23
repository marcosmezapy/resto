<?php

namespace App\Livewire\Empresa;

use Livewire\Component;
use Illuminate\Support\Facades\Auth;

class CrudEmpresa extends Component
{
    public $razon_social, $ruc, $direccion, $telefono, $email, $mensaje_ticket;

    public function mount()
    {
        $tenant = Auth::user()->tenant;

        // 🆕 SEGURIDAD
        if(!$tenant){
            abort(403, 'Usuario sin tenant asignado');
        }

        // 🆕 CARGAR DATOS EXISTENTES
        $this->razon_social = $tenant->razon_social;
        $this->ruc = $tenant->ruc;
        $this->direccion = $tenant->direccion;
        $this->telefono = $tenant->telefono;
        $this->email = $tenant->email;
        $this->mensaje_ticket = $tenant->mensaje_ticket;
    }

    public function actualizar()
    {
        $this->validate([
            'razon_social' => 'required|string|max:255',
            'ruc' => 'required|string|max:50',
            'direccion' => 'nullable|string|max:255',
            'telefono' => 'nullable|string|max:50',
            'email' => 'nullable|email|max:255',
            'mensaje_ticket' => 'nullable|string'
        ]);

        $tenant = Auth::user()->tenant;

        // 🆕 SEGURIDAD
        if(!$tenant){
            abort(403);
        }

        // 🆕 SOLO UPDATE
        $tenant->update([
            'razon_social' => $this->razon_social,
            'ruc' => $this->ruc,
            'direccion' => $this->direccion,
            'telefono' => $this->telefono,
            'email' => $this->email,
            'mensaje_ticket' => $this->mensaje_ticket,
        ]);

        session()->flash('message', 'Datos de la empresa actualizados correctamente');
    }

    public function render()
    {
        return view('livewire.empresa.crud-empresa');
    }
}
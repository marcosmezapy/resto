<?php

namespace App\Livewire\Clientes;

use Livewire\Component;
use App\Models\Cliente;
use App\Services\Clientes\ClienteService;

class ClienteForm extends Component
{
    public $clienteId;

    public $nombre;
    public $ruc;
    public $telefono;
    public $email;
    public $direccion;
    public $activo = 1;

    public function mount($clienteId = null)
    {
        if($clienteId){
            $cliente = Cliente::findOrFail($clienteId);

            $this->clienteId = $cliente->id;

            $this->nombre = $cliente->nombre;
            $this->ruc = $cliente->ruc;
            $this->telefono = $cliente->telefono;
            $this->email = $cliente->email;
            $this->direccion = $cliente->direccion;
            $this->activo = $cliente->activo;
        }
    }

    public function save()
    {
        $data = $this->validate([
            'nombre' => 'required|max:255',
            'ruc' => 'nullable|max:255',
            'telefono' => 'nullable|max:255',
            'email' => 'nullable|email',
            'direccion' => 'nullable|max:255',
            'activo' => 'boolean'
        ]);

        $service = app(ClienteService::class);

        if($this->clienteId){
            $cliente = Cliente::findOrFail($this->clienteId);
            $service->update($cliente, $data);
        } else {
            $service->store($data);
        }

        session()->flash('success','Cliente guardado correctamente');

        return redirect()->route('clientes.index');
    }

    public function render()
    {
        return view('livewire.clientes.cliente-form');
    }
}
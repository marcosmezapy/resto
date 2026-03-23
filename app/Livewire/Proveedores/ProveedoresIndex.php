<?php

namespace App\Livewire\Proveedores;

use Livewire\Component;
use App\Models\Proveedor;

class ProveedoresIndex extends Component
{
    public $proveedores;
    public $mostrarForm = false;

    public $nombre, $ruc, $telefono, $email, $direccion;
    public $proveedor_id;

    public $modoEdicion = false;

    public function mount()
    {
        $this->cargar();
    }

    public function cargar()
    {
        $this->proveedores = Proveedor::latest()->get();
    }

public function guardar()
{
    $this->validate([
        'nombre' => 'required|string|max:255',
    ]);

    Proveedor::create([
        'nombre' => $this->nombre,
        'ruc' => $this->ruc,
        'telefono' => $this->telefono,
        'email' => $this->email,
        'direccion' => $this->direccion,
    ]);

    $this->resetCampos();
    $this->mostrarForm = false; // 🔥 OCULTAR
    $this->cargar();
}

public function editar($id)
{
    $proveedor = Proveedor::findOrFail($id);

    $this->proveedor_id = $id;
    $this->nombre = $proveedor->nombre;
    $this->ruc = $proveedor->ruc;
    $this->telefono = $proveedor->telefono;
    $this->email = $proveedor->email;
    $this->direccion = $proveedor->direccion;

    $this->modoEdicion = true;
    $this->mostrarForm = true; // 🔥 MOSTRAR
}

public function actualizar()
{
    $this->validate([
        'nombre' => 'required|string|max:255',
    ]);

    $proveedor = Proveedor::findOrFail($this->proveedor_id);

    $proveedor->update([
        'nombre' => $this->nombre,
        'ruc' => $this->ruc,
        'telefono' => $this->telefono,
        'email' => $this->email,
        'direccion' => $this->direccion,
    ]);

    $this->resetCampos();
    $this->modoEdicion = false;
    $this->mostrarForm = false; // 🔥 OCULTAR
    $this->cargar();
}

    public function eliminar($id)
    {
        Proveedor::findOrFail($id)->delete();
        $this->cargar();
    }

    public function resetCampos()
    {
        $this->reset([
            'nombre',
            'ruc',
            'telefono',
            'email',
            'direccion',
            'proveedor_id'
        ]);
    }

    public function nuevo()
{
    $this->resetCampos();
    $this->modoEdicion = false;
    $this->mostrarForm = true;
}

public function cancelar()
{
    $this->resetCampos();
    $this->modoEdicion = false;
    $this->mostrarForm = false;
}

    public function render()
    {
        return view('livewire.proveedores.proveedores-index');
    }


}
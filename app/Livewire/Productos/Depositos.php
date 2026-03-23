<?php

namespace App\Livewire\Productos;

use Livewire\Component;
use App\Models\PrdDeposito;

class Depositos extends Component
{
    public $nombre;
    public $descripcion;
    public $deposito_id;

    public $showForm = false;

    public $depositos;

    public function mount()
    {
        $this->loadDepositos();
    }

    public function loadDepositos()
    {
        $this->depositos = PrdDeposito::orderBy('id', 'desc')->get();
    }

    public function toggleForm()
    {
        $this->resetInputFields();
        $this->showForm = !$this->showForm;
    }

    public function resetInputFields()
    {
        $this->nombre = '';
        $this->descripcion = '';
        $this->deposito_id = null;
    }

    public function store()
    {
        $this->validate([
            'nombre' => 'required|string|max:255',
            'descripcion' => 'nullable|string|max:500',
        ]);

        PrdDeposito::updateOrCreate(
            ['id' => $this->deposito_id],
            [
                'nombre' => $this->nombre,
                'descripcion' => $this->descripcion,
            ]
        );

        session()->flash('message', $this->deposito_id ? 'Depósito actualizado correctamente.' : 'Depósito creado correctamente.');

        $this->resetInputFields();
        $this->showForm = false;
        $this->loadDepositos();
    }

    public function edit($id)
    {
        $deposito = PrdDeposito::findOrFail($id);
        $this->deposito_id = $id;
        $this->nombre = $deposito->nombre;
        $this->descripcion = $deposito->descripcion;
        $this->showForm = true;
    }

    public function delete($id)
    {
        $deposito = PrdDeposito::findOrFail($id);
        $deposito->delete();
        session()->flash('message', 'Depósito eliminado correctamente.');
        $this->loadDepositos();
    }

    public function render()
    {
        return view('livewire.productos.depositos');
    }
}
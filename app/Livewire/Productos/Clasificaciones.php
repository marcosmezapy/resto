<?php

namespace App\Livewire\Productos;

use Livewire\Component;
use App\Models\PrdClasificacion; // Asegurate de tener el modelo

class Clasificaciones extends Component
{
    public $nombre;
    public $descripcion;
    public $clasificacion_id;

    public $showForm = false;
    public $clasificaciones;

    public function mount()
    {
        $this->loadClasificaciones();
    }

    public function loadClasificaciones()
    {
        $this->clasificaciones = PrdClasificacion::orderBy('id', 'desc')->get();
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
        $this->clasificacion_id = null;
    }

    public function store()
    {
        $this->validate([
            'nombre' => 'required|string|max:255',
            'descripcion' => 'nullable|string|max:500',
        ]);

        PrdClasificacion::updateOrCreate(
            ['id' => $this->clasificacion_id],
            [
                'nombre' => $this->nombre,
                'descripcion' => $this->descripcion,
            ]
        );

        session()->flash('message', $this->clasificacion_id ? 'Clasificación actualizada correctamente.' : 'Clasificación creada correctamente.');

        $this->resetInputFields();
        $this->showForm = false;
        $this->loadClasificaciones();
    }

    public function edit($id)
    {
        $clasificacion = PrdClasificacion::findOrFail($id);
        $this->clasificacion_id = $id;
        $this->nombre = $clasificacion->nombre;
        $this->descripcion = $clasificacion->descripcion;
        $this->showForm = true;
    }

    public function delete($id)
    {
        $clasificacion = PrdClasificacion::findOrFail($id);
        $clasificacion->delete();
        session()->flash('message', 'Clasificación eliminada correctamente.');
        $this->loadClasificaciones();
    }

    public function render()
    {
        return view('livewire.productos.clasificaciones');
    }
}
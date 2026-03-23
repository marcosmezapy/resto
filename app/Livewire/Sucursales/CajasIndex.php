<?php

namespace App\Livewire\Sucursales;

use Livewire\Component;
use App\Models\Caja;
use App\Models\Sucursal;
use App\Models\PuntoExpedicion;

class CajasIndex extends Component
{
    public $cajas = [];
    public $sucursales = [];
    public $puntos = [];

    public $sucursal_id;
    public $punto_expedicion_id;

    public $nombre;
    public $descripcion;
    public $activa = true;

    public $editando = false;
    public $caja_id;

    public function mount()
    {
        $this->sucursales = Sucursal::where('tenant_id', tenant_id())->get();
        $this->cargar();
    }

    public function updatedSucursalId()
    {
 

        // 🔥 limpiar puntos si no hay sucursal
        if (!$this->sucursal_id) {
            $this->puntos = [];
            return;
        }

        // 🔥 traer SOLO puntos con timbrado vigente
        $this->puntos = PuntoExpedicion::where('tenant_id', tenant_id())
            ->where('sucursal_id', $this->sucursal_id)
            ->whereHas('timbrados', function ($q) {
                $q->where('estado', 'vigente')
                  ->where('activo', 1);
            })
            ->get();

        $this->punto_expedicion_id = null;
    }

    public function cargar()
    {
        $this->cajas = Caja::where('tenant_id', tenant_id())
            ->with('puntoExpedicion.sucursal')
            ->orderBy('id','desc')
            ->get();
    }

    public function guardar()
    {
        $this->validate([
            'nombre' => 'required',
            'sucursal_id' => 'required',
            'punto_expedicion_id' => 'required'
        ]);

        if ($this->editando) {

            $caja = Caja::findOrFail($this->caja_id);

            $caja->update([
                'nombre' => $this->nombre,
                'descripcion' => $this->descripcion,
                'activa' => $this->activa ? 1 : 0,
                'sucursal_id' => $this->sucursal_id,
                'punto_expedicion_id' => $this->punto_expedicion_id
            ]);

        } else {

            Caja::create([
                'tenant_id' => tenant_id(),
                'sucursal_id' => $this->sucursal_id,
                'punto_expedicion_id' => $this->punto_expedicion_id,
                'nombre' => $this->nombre,
                'descripcion' => $this->descripcion,
                'activa' => $this->activa ? 1 : 0
            ]);
        }

        $this->reset([
            'nombre',
            'descripcion',
            'activa',
            'punto_expedicion_id',
            'sucursal_id',
            'editando',
            'caja_id'
        ]);

        $this->puntos = [];

        $this->cargar();
    }

    public function editar($id)
    {
        $caja = Caja::with('puntoExpedicion')->findOrFail($id);

        $this->caja_id = $caja->id;
        $this->nombre = $caja->nombre;
        $this->descripcion = $caja->descripcion;
        $this->activa = $caja->activa;

        $this->sucursal_id = $caja->sucursal_id;

        // 🔥 cargar puntos válidos
        $this->puntos = PuntoExpedicion::where('tenant_id', tenant_id())
            ->where('sucursal_id', $this->sucursal_id)
            ->whereHas('timbrados', function ($q) {
                $q->where('estado', 'vigente')
                  ->where('activo', 1);
            })
            ->get();

        $this->punto_expedicion_id = $caja->punto_expedicion_id;

        $this->editando = true;
    }

    public function toggle($id)
    {
        $caja = Caja::findOrFail($id);
        $caja->activa = !$caja->activa;
        $caja->save();

        $this->cargar();
    }

    public function render()
    {
        return view('livewire.sucursales.cajas');
    }
}
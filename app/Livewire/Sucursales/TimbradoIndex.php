<?php

namespace App\Livewire\Sucursales;

use Livewire\Component;
use App\Models\Timbrado;
use App\Models\PuntoExpedicion;
use App\Models\Sucursal;

class TimbradoIndex extends Component
{
    public $timbrados = [];
    public $puntos = [];
    public $sucursales = [];

    public $sucursal_id;
    public $punto_expedicion_id;

    public $numero_timbrado;
    public $numero_inicio;
    public $numero_fin;
    public $fecha_inicio;
    public $fecha_fin;

    public function mount()
    {
        // 🔥 cargar sucursales
        $this->sucursales = Sucursal::where('tenant_id', tenant_id())->get();

        $this->cargar();
    }

    public function cargar()
    {
        $this->timbrados = Timbrado::where('tenant_id', tenant_id())
            ->with('puntoExpedicion.sucursal')
            ->orderBy('id', 'desc')
            ->get();
    }

    // 🔥 cuando cambia sucursal → filtrar puntos
    public function updatedSucursalId()
    {
        if (!$this->sucursal_id) {
            $this->puntos = [];
            return;
        }

        $this->puntos = PuntoExpedicion::where('tenant_id', tenant_id())
            ->where('sucursal_id', $this->sucursal_id)
            ->get();

        $this->punto_expedicion_id = null;
    }

    public function guardar()
    {
        $this->validate([
            'sucursal_id' => 'required',
            'punto_expedicion_id' => 'required',
            'numero_timbrado' => 'required',
            'numero_inicio' => 'required|integer|min:1',
            'numero_fin' => 'required|integer|gte:numero_inicio',
            'fecha_inicio' => 'required|date',
            'fecha_fin' => 'required|date|after_or_equal:fecha_inicio',
        ]);

        // 🔥 traer punto real
        $punto = PuntoExpedicion::findOrFail($this->punto_expedicion_id);

        // 🔥 VALIDACIÓN PRO (evita inconsistencias)
        if ($punto->sucursal_id != $this->sucursal_id) {
            abort(403, 'El punto no pertenece a la sucursal seleccionada');
        }

        // 🔥 desactivar timbrado vigente del mismo punto
        Timbrado::where('punto_expedicion_id', $this->punto_expedicion_id)
            ->where('estado', 'vigente')
            ->update([
                'estado' => 'vencido',
                'activo' => 0
            ]);

        // 🔥 crear timbrado
        Timbrado::create([
            'tenant_id' => tenant_id(),
            'sucursal_id' => $punto->sucursal_id, // 🔥 SIEMPRE desde punto
            'punto_expedicion_id' => $this->punto_expedicion_id,
            'numero_timbrado' => $this->numero_timbrado,
            'numero_inicio' => $this->numero_inicio,
            'numero_fin' => $this->numero_fin,
            'ultimo_numero_usado' => 0,
            'fecha_inicio' => $this->fecha_inicio,
            'fecha_fin' => $this->fecha_fin,
            'estado' => 'vigente',
            'activo' => 1
        ]);

        $this->reset([
            'sucursal_id',
            'punto_expedicion_id',
            'numero_timbrado',
            'numero_inicio',
            'numero_fin',
            'fecha_inicio',
            'fecha_fin'
        ]);

        $this->puntos = [];

        $this->cargar();
    }

    public function render()
    {
        return view('livewire.sucursales.timbrados');
    }
}
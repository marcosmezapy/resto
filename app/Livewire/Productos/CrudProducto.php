<?php

namespace App\Livewire\Productos;

use App\Models\IvaTipo;
use Livewire\Component;
use App\Models\PrdProducto;
use App\Models\PrdClasificacion;

class CrudProducto extends Component
{
    public $productos,$iva_tipo_id, $nombre,$costo_base,$precio_venta, $descripcion, $sku, $es_stockeable = true, $clasificacion_id, $producto_id;
    public $updateMode = false;
    public $showForm = false; // <-- controla visibilidad del formulario

    public function render()
    {
        $this->productos = PrdProducto::with('clasificacion','stocks')->get();
        $clasificaciones = PrdClasificacion::all();
        $ivaTipos = IvaTipo::all();
        return view('livewire.productos.crud-producto', compact('clasificaciones','ivaTipos'));
    }

    public function resetInputFields()
    {
        $this->nombre = '';
        $this->descripcion = '';
        $this->sku = '';
        $this->es_stockeable = true;
        $this->clasificacion_id = '';
        $this->costo_base = '';
        $this->precio_venta = '';
        $this->producto_id = null;
        $this->updateMode = false;
        $this->iva_tipo_id = null;
    }

    public function toggleForm()
    {
        $this->showForm = !$this->showForm;
        if(!$this->showForm) {
            $this->resetInputFields();
        }
    }

    public function store()
    {
        $this->validate([
            'nombre' => 'required|string',
            'sku' => 'required|unique:prd_productos,sku,' . $this->producto_id,
            'clasificacion_id' => 'required|exists:prd_clasificaciones,id',
            'iva_tipo_id' => 'required|exists:iva_tipos,id'
        ]);

        PrdProducto::updateOrCreate(['id' => $this->producto_id], [
            'nombre' => $this->nombre,
            'descripcion' => $this->descripcion,
            'sku' => $this->sku,
            'es_stockeable' => (bool)$this->es_stockeable,
            'clasificacion_id' => $this->clasificacion_id,
            'costo_base' => $this->es_stockeable ? null : $this->costo_base,
            'precio_venta' => $this->precio_venta,
            'iva_tipo_id' => $this->iva_tipo_id
        ]);

        session()->flash('message', $this->producto_id ? 'Producto actualizado' : 'Producto creado');

        $this->resetInputFields();
        $this->showForm = false; // ocultar el formulario luego de guardar
    }

    public function edit($id)
    {
        $producto = PrdProducto::findOrFail($id);
        $this->producto_id = $id;
        $this->nombre = $producto->nombre;
        $this->descripcion = $producto->descripcion;
        $this->sku = $producto->sku;
        $this->es_stockeable = $producto->es_stockeable;
        $this->clasificacion_id = $producto->clasificacion_id;
        $this->updateMode = true;
        $this->costo_base = $producto->costo_base;
        $this->precio_venta = $producto->precio_venta;
        $this->iva_tipo_id = $producto->iva_tipo_id;
        $this->showForm = true; // mostrar formulario cuando editamos
    }

    public function delete($id)
    {
        PrdProducto::find($id)->delete();
        session()->flash('message', 'Producto eliminado');
    }
}
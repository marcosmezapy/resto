<?php

namespace App\Livewire\Ventas;

use Livewire\Component;
use Livewire\WithPagination;
use App\Models\Caja;

class CajasTable extends Component
{

    use WithPagination;

    public $search = '';

    protected $paginationTheme = 'bootstrap';

    public function updatingSearch()
    {
        $this->resetPage();
    }

    public function render()
    {

    $cajas = Caja::where('sucursal_id', session('sucursal_id')) // 🔥
        ->where('nombre','like',"%{$this->search}%")
        ->paginate(10);

        return view('livewire.ventas.cajas-table', compact('cajas'));
    }

}
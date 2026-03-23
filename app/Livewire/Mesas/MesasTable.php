<?php

namespace App\Livewire\Mesas;

use Livewire\Component;
use Livewire\WithPagination;
use App\Models\Mesa;

class MesasTable extends Component
{

    use WithPagination;

    public $search='';

    protected $paginationTheme='bootstrap';

    public function updatingSearch()
    {
        $this->resetPage();
    }

    public function render()
    {
        $mesas = Mesa::where('sucursal_id', session('sucursal_id')) // 🔥 FILTRO
            ->where('numero','like',"%{$this->search}%")
            ->paginate(10);

        return view('livewire.mesas.mesas-table', compact('mesas'));
    }

}
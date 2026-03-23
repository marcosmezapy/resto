<?php

namespace App\Livewire\Clientes;

use Livewire\Component;
use Livewire\WithPagination;
use App\Models\Cliente;

class ClientesTable extends Component
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

        $clientes = Cliente::where('nombre','like',"%{$this->search}%")
            ->orWhere('ruc','like',"%{$this->search}%")
            ->orWhere('telefono','like',"%{$this->search}%")
            ->paginate(10);

        return view('livewire.clientes.clientes-table',compact('clientes'));
    }
}
<?php

namespace App\Livewire\Clientes;

use Livewire\Component;
use Livewire\WithPagination;
use App\Models\Cliente;

class ClientesIndex extends Component
{
    use WithPagination;

    protected $paginationTheme = 'bootstrap';

    public $search = '';

    public function updatingSearch()
    {
        $this->resetPage();
    }

    public function render()
    {
        $clientes = Cliente::query()
            ->where(function($q){
                $q->where('nombre','like',"%{$this->search}%")
                  ->orWhere('ruc','like',"%{$this->search}%")
                  ->orWhere('telefono','like',"%{$this->search}%")
                  ->orWhere('email','like',"%{$this->search}%");
            })
            ->orderBy('id','desc')
            ->paginate(20);

        return view('livewire.clientes.clientes-index', compact('clientes'));
    }
}
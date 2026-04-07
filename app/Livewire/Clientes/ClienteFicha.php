<?php

namespace App\Livewire\Clientes;

use Livewire\Component;
use App\Models\Cliente;
use App\Services\Clientes\ClienteStatsService;
use App\Services\Clientes\ClienteCreditoService;

use Livewire\WithPagination;

class ClienteFicha extends Component
{
    use WithPagination;

    protected $paginationTheme = 'bootstrap';

    public $cliente;

    public function mount($id)
    {
        $this->cliente = Cliente::findOrFail($id);
    }

    public function render()
    {
        $stats = app(ClienteStatsService::class)
            ->fullStats($this->cliente->id);

        $credito = app(ClienteCreditoService::class)
            ->detalle($this->cliente->id);

        return view('livewire.clientes.cliente-ficha',[
            'stats'=>$stats,
            'credito'=>$credito
        ]);
    }
}
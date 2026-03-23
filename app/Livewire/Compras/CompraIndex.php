<?php

namespace App\Livewire\Compras;

use Livewire\Component;
use Livewire\WithPagination;
use App\Models\Compra;
use Illuminate\Support\Facades\Auth;

class CompraIndex extends Component
{
    public function render()
    {
        $tenantId = Auth::user()->tenant_id;
        $sucursalId = session('sucursal_id');

        $compras = Compra::where('tenant_id', $tenantId)
            ->where('sucursal_id', $sucursalId)
            ->latest()
            ->get();

        return view('livewire.compras.index', compact('compras'));
    }
}
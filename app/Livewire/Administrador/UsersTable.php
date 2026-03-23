<?php

namespace App\Livewire\Administrador;

use Livewire\Component;
use Livewire\WithPagination;
use App\Models\User;

class UsersTable extends Component
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
        $users = User::where('name', 'like', "%{$this->search}%")
                     ->orWhere('email', 'like', "%{$this->search}%")
                     ->paginate(10);

        return view('livewire.administrador.users-table', compact('users'));
    }
}
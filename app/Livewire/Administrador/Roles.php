<?php

namespace App\Livewire\Administrador;

use Livewire\Component;
use Livewire\WithPagination;
use Spatie\Permission\Models\Role;

class Roles extends Component
{

    use WithPagination;

    public $search = '';

    protected $listeners = [
        'roleCreated' => '$refresh'
    ];

    public function delete($id)
    {
        Role::findOrFail($id)->delete();
    }

    public function render()
    {

        $roles = Role::where('name','like','%'.$this->search.'%')
            ->orderBy('id','desc')
            ->paginate(10);

        return view('livewire.administrador.roles-index', compact('roles'));

    }
}
<?php

namespace App\Livewire\Administrador;

use Livewire\Component;
use Spatie\Permission\Models\Role;
use App\Models\Permission;
use Illuminate\Support\Collection;

class RolesForm extends Component
{

    public $roleId;

    public $name;

    public Collection $permissions;

    public $selectedPermissions = [];

    public $selectAll = false;

    protected $listeners = [
        'openRoleForm' => 'create',
        'editRole' => 'edit'
    ];

    public function mount()
    {

           // Traemos permisos solo de submódulos activos y módulos activos
    $this->permissions = Permission::whereHas('submodule', function ($q) {
        $q->where('active', 1) // submodulo activo
          ->whereHas('module', function ($q2) {
              $q2->where('active', 1); // modulo activo
          });
    })->orderBy('name')->get();

    }

    public function create()
    {

        $this->reset([
            'roleId',
            'name',
            'selectedPermissions',
            'selectAll'
        ]);

    }

    public function edit($id)
    {

        $role = Role::findOrFail($id);

        $this->roleId = $role->id;

        $this->name = $role->name;

        $this->selectedPermissions = $role->permissions
            ->pluck('name')
            ->toArray();

        if(count($this->selectedPermissions) == $this->permissions->count())
        {
            $this->selectAll = true;
        }

    }

    public function updatedSelectAll($value)
    {

        if($value)
        {

            $this->selectedPermissions =
                $this->permissions
                ->pluck('name')
                ->toArray();

        }
        else
        {

            $this->selectedPermissions = [];

        }

    }

    public function save()
    {

        $this->validate([
            'name' => 'required|unique:roles,name,'.$this->roleId
        ]);

        $role = Role::updateOrCreate(

            ['id' => $this->roleId],

            ['name' => $this->name]

        );

        $role->syncPermissions($this->selectedPermissions);

        $this->dispatch('roleCreated');

        $this->create();

    }

    public function render()
    {

        return view('livewire.administrador.roles-form');

    }

}
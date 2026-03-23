<?php

namespace App\Models;

use Spatie\Permission\Models\Permission as SpatiePermission;

class Permission extends SpatiePermission
{
    protected $table = 'permissions';

    public function module()
    {
        return $this->belongsTo(Module::class, 'module_id');
    }

    public function submodule()
    {
        return $this->belongsTo(Submodule::class, 'submodule_id');
    }
}
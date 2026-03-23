<?php

// app/Models/Module.php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Spatie\Permission\Models\Permission;

class Module extends Model
{
    use HasFactory;

    protected $fillable = ['name', 'active'];

    public function submodules()
    {
        return $this->hasMany(SubModule::class, 'module_id');
    }

    public function permissions()
    {
        return $this->hasMany(Permission::class);
    }
}
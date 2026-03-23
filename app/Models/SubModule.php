<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Spatie\Permission\Models\Permission;


class SubModule extends Model
{
    use HasFactory;

    protected $fillable = ['name', 'module_id', 'active'];
    protected $table = 'submodules';

    public function module()
    {
        return $this->belongsTo(Module::class);
    }

    public function permissions()
    {
        return $this->hasMany(Permission::class, 'submodule_id');
    }
}
<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Module;
use App\Models\SubModule;
use Spatie\Permission\Models\Permission;
use Illuminate\Support\Facades\DB;
use Spatie\Permission\PermissionRegistrar;

class SubModuleController extends Controller
{
    public function store(Request $request, Module $module)
    {
        $this->authorize('administrador.modulos.create');

        $request->validate([
            'name' => 'required|string|max:255|unique:submodules,name,NULL,id,module_id,' . $module->id,
        ]);

        $submodule = $module->submodules()->create([
            'name' => $request->name,
            'active' => true,
        ]);

        foreach(['index','create','edit','delete'] as $action) {
            Permission::create([
                'name' => "{$module->name}.{$submodule->name}.{$action}",
                'module_id' => $module->id,
                'submodule_id' => $submodule->id,
                'guard_name' => 'web',
            ]);
        }

        return back()->with('success', 'Submódulo creado con permisos.');
    }

    public function update(Request $request, SubModule $submodule)
    {
        $this->authorize('administrador.modulos.edit');

        $request->validate([
            'name' => 'required|string|max:255|unique:submodules,name,' . $submodule->id . ',id,module_id,' . $submodule->module_id,
        ]);

        $active = $request->has('active');

        $submodule->update([
            'name' => $request->name,
            'active' => $active,
        ]);

        if (!$active) {
            // Desvincular permisos del submódulo de todos los roles
            $permissionIds = Permission::where('submodule_id', $submodule->id)->pluck('id');
            DB::table('role_has_permissions')->whereIn('permission_id', $permissionIds)->delete();
        } else {
            // Actualizar nombres de permisos si cambia el nombre
            foreach($submodule->permissions as $perm) {
                $action = collect(['index','create','edit','delete'])
                    ->first(fn($a) => str_ends_with($perm->name, ".$a"));
                $perm->update([
                    'name' => "{$submodule->module->name}.{$submodule->name}.{$action}"
                ]);
            }
        }

        // Refrescar caché de Spatie
        app()[PermissionRegistrar::class]->forgetCachedPermissions();

        return back()->with('success', 'Submódulo actualizado.');
    }

    public function destroy(SubModule $submodule)
    {
        $this->authorize('administrador.modulos.delete');

        // Desvincular permisos de roles antes de eliminar
        $permissionIds = $submodule->permissions()->pluck('id');
        DB::table('role_has_permissions')->whereIn('permission_id', $permissionIds)->delete();

        $submodule->permissions()->delete();
        $submodule->delete();

        // Refrescar caché
        app()[PermissionRegistrar::class]->forgetCachedPermissions();

        return back()->with('success', 'Submódulo eliminado.');
    }
}
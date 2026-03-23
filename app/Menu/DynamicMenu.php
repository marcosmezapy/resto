<?php

namespace App\Menu;

use JeroenNoten\LaravelAdminLte\Menu\Filters\FilterInterface;
use App\Models\Module;
use Illuminate\Support\Facades\Auth;

class DynamicMenu implements FilterInterface
{
    public function transform($item)
    {
        if ($item !== 'DYNAMIC_MENU') {
            return $item;
        }

        $menu = [];
        $user = Auth::user();

        if (!$user) {
            return $menu;
        }

        $modules = Module::with(['submodules' => function ($q) {
            $q->where('active', 1);
        }, 'submodules.permissions']) // traemos los permisos relacionados
        ->where('active', 1)
        ->get();

        foreach ($modules as $module) {
            $submenu = [];

            foreach ($module->submodules as $sub) {

                // Obtenemos todos los permisos de este submódulo que el usuario tenga y terminen en .index
                $subPermission = $sub->permissions
                                     ->filter(fn($perm) => str_ends_with($perm->name, '.index'))
                                     ->firstWhere(fn($perm) => $user->can($perm->name));

                if ($subPermission) {
                    $submenu[] = [
                        'text' => $sub->name,
                        'route' => $subPermission->name, // usamos el nombre del permiso como ruta
                        'icon' => $sub->icon ?? 'far fa-circle',
                    ];
                }
            }

            if (!empty($submenu)) {
                $menu[] = [
                    'text' => $module->name,
                    'icon' => $module->icon ?? 'fas fa-folder',
                    'submenu' => $submenu,
                ];
            }
        }

        return $menu;
    }
}
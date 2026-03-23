<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\Auth;
use App\Models\Module;
use App\Models\Submodule;

class AdminLteMenuServiceProvider extends ServiceProvider
{
    public function boot()
    {
        $this->app->booted(function () {

            $user = Auth::user();
            if (!$user) return; // Si no hay usuario logueado, no hacemos nada

            // Obtenemos el menú estático de adminlte
            $menu = config('adminlte.menu', []);

            // Filtramos los ítems según permisos y activación
            $menu = $this->filterMenu($menu, $user);

            // Reemplazamos el menú en la configuración
            config(['adminlte.menu' => $menu]);
        });
    }

    /**
     * Filtra el menú recursivamente.
     */
    protected function filterMenu(array $menuItems, $user)
    {
        $filtered = [];

        foreach ($menuItems as $item) {

            // --- Verificamos módulo ---
            if (isset($item['module_id'])) {
                $module = Module::find($item['module_id']);
                if (!$module || !$module->active) continue; // Módulo desactivado
            }

            // --- Verificamos submenú si existe ---
            if (isset($item['submenu'])) {
                $item['submenu'] = $this->filterMenu($item['submenu'], $user);

                // Si después de filtrar no queda nada en el submenu, descartamos el item
                if (empty($item['submenu'])) continue;
            }

            // --- Verificamos submódulo ---
            if (isset($item['submodule_id'])) {
                $submodule = Submodule::find($item['submodule_id']);
                if (!$submodule || !$submodule->active) continue;
            }

            // --- Verificamos permisos ---
            if (isset($item['can']) && !$user->can($item['can'])) {
                continue; // Usuario no tiene permiso
            }

            // Si pasa todas las condiciones, lo agregamos al menú filtrado
            $filtered[] = $item;
        }

        return $filtered;
    }
}
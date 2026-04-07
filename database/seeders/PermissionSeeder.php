<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\PermissionRegistrar;

class PermissionSeeder extends Seeder
{
    public function run(): void
    {
        // Reset cache
        app()[PermissionRegistrar::class]->forgetCachedPermissions();

        /**
         * 🔥 1. PERMISO SUPERADMIN (PRIMERO SIEMPRE)
         */
        Permission::firstOrCreate([
            'name' => 'superadmin',
        ]);

        /**
         * 📦 2. MODULOS DEL SISTEMA
         */
        $modulos = [
            'ventas',
            'caja_sesion',
            'caja',
            'clientes',
            'productos',
            'depositos',
            'stock',
            'compras',
            'proveedores',
            'mesas',
            'reportes',
        ];

        /**
         * ⚙️ 3. ACCIONES CRUD
         */
        $acciones = [
            'index',
            'show',
            'create',
            'store',
            'edit',
            'update',
            'delete',
        ];

        /**
         * 🔁 4. CREAR PERMISOS CRUD
         */
        foreach ($modulos as $modulo) {
            foreach ($acciones as $accion) {
                Permission::firstOrCreate([
                    'name' => "{$modulo}.{$accion}",
                ]);
            }
        }

        /**
         * 🚀 5. PERMISOS ESPECIALES (MUY IMPORTANTE)
         */
        $permisosEspeciales = [
            'caja.apertura',
            'caja.cierre',
            'ventas.cobrar',
        ];

        foreach ($permisosEspeciales as $permiso) {
            Permission::firstOrCreate([
                'name' => $permiso,
            ]);
        }
    }
}
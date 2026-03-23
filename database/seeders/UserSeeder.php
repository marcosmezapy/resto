<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;
use App\Models\Tenant;
use Illuminate\Support\Facades\DB;

class UserSeeder extends Seeder
{
    public function run(): void
    {
        // =========================
        // TENANT
        // =========================
        $tenant = Tenant::updateOrCreate(
            ['id' => 1],
            [
                'nombre' => 'EMPRESA GENERICA',
                'estado' => 'activo',
                'razon_social' => 'EMPRESA GENERICA S.A.',
                'ruc' => '80000001-0',
                'direccion' => 'Asunción, Paraguay',
                'telefono' => '000000000',
                'email' => 'empresa@demo.com',
                'tipo_facturacion' => 'informal' // 🔥
            ]
        );

        // =========================
        // SUCURSALES
        // =========================
        DB::table('sucursales')->updateOrInsert(
            ['id' => 1],
            [
                'tenant_id' => $tenant->id,
                'nombre' => 'CASA MATRIZ',
                'codigo' => '001',
                'direccion' => 'Casa Central',
                'telefono' => null,
                'email' => null,
                'activo' => 1,
                'created_at' => now(),
                'updated_at' => now(),
            ]
        );

        DB::table('sucursales')->updateOrInsert(
            ['id' => 2],
            [
                'tenant_id' => $tenant->id,
                'nombre' => 'CASA DOS',
                'codigo' => '002',
                'direccion' => 'Sucursal 2',
                'telefono' => null,
                'email' => null,
                'activo' => 1,
                'created_at' => now(),
                'updated_at' => now(),
            ]
        );

        // =========================
        // USER ADMIN
        // =========================
        $user = User::updateOrCreate(
            ['id' => 1],
            [
                'name' => 'admin',
                'email' => 'admin@example.com',
                'password' => bcrypt('admin123'),
                'tenant_id' => $tenant->id,
            ]
        );

        // =========================
        // RELACION USER - SUCURSALES
        // =========================
        DB::table('sucursal_user')->updateOrInsert(
            [
                'user_id' => $user->id,
                'sucursal_id' => 1
            ],
            [
                'tenant_id' => $tenant->id,
                'es_principal' => 1,
                'activo' => 1,
                'created_at' => now(),
                'updated_at' => now(),
            ]
        );

        DB::table('sucursal_user')->updateOrInsert(
            [
                'user_id' => $user->id,
                'sucursal_id' => 2
            ],
            [
                'tenant_id' => $tenant->id,
                'es_principal' => 0,
                'activo' => 1,
                'created_at' => now(),
                'updated_at' => now(),
            ]
        );
    }
}
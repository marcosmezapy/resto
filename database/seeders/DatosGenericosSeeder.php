<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

class DatosGenericosSeeder extends Seeder
{
    public function run(): void
    {
        $now = Carbon::now();

        // =========================
        // CLIENTE GENERICO
        // =========================
        DB::table('clientes')->insert([
            'tenant_id' => 1,
            'nombre' => 'CLIENTE GENERICO',
            'ruc' => '0',
            'telefono' => null,
            'email' => null,
            'direccion' => null,
            'activo' => 1,
            'created_at' => $now,
            'updated_at' => $now,
        ]);

        // =========================
        // PROVEEDOR GENERICO
        // =========================
        DB::table('proveedores')->insert([
            'tenant_id' => 1,
            'nombre' => 'PROVEEDOR GENERICO',
            'ruc' => '0',
            'telefono' => null,
            'email' => null,
            'direccion' => null,
            'created_at' => $now,
            'updated_at' => $now,
        ]);

        // =========================
        // SUCURSAL 1
        // =========================

        // DEPOSITO
        DB::table('prd_depositos')->insert([
            'tenant_id' => 1,
            'sucursal_id' => 1,
            'nombre' => 'DEPOSITO PRINCIPAL',
            'ubicacion' => 'Casa Matriz',
            'created_at' => $now,
            'updated_at' => $now,
        ]);

        // CAJA
        DB::table('cajas')->insert([
            'tenant_id' => 1,
            'sucursal_id' => 1,
            'nombre' => 'CAJA PRINCIPAL',
            'descripcion' => 'Caja Casa Matriz',
            'activa' => 1,
            'created_at' => $now,
            'updated_at' => $now,
        ]);

        // =========================
        // SUCURSAL 2
        // =========================

        // DEPOSITO
        DB::table('prd_depositos')->insert([
            'tenant_id' => 1,
            'sucursal_id' => 2,
            'nombre' => 'DEPOSITO SUCURSAL 2',
            'ubicacion' => 'Sucursal 2',
            'created_at' => $now,
            'updated_at' => $now,
        ]);

        // CAJA
        DB::table('cajas')->insert([
            'tenant_id' => 1,
            'sucursal_id' => 2,
            'nombre' => 'CAJA SUCURSAL 2',
            'descripcion' => 'Caja Casa Dos',
            'activa' => 1,
            'created_at' => $now,
            'updated_at' => $now,
        ]);
    }
}
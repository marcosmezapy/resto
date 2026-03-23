<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class SecuritySeeder extends Seeder
{
    public function run(): void
    {

        /*
        |---------------------------------------
        | MODULES
        |---------------------------------------
        */

        DB::table('modules')->insert([
            ['id'=>1,'name'=>'administrador','active'=>1],
            ['id'=>2,'name'=>'productos','active'=>1],
            ['id'=>3,'name'=>'clientes','active'=>1],
            ['id'=>4,'name'=>'mesas','active'=>1],
            ['id'=>5,'name'=>'ventas','active'=>1],
        ]);


        /*
        |---------------------------------------
        | SUBMODULES
        |---------------------------------------
        */

        DB::table('submodules')->insert([

            ['id'=>1,'module_id'=>1,'name'=>'usuarios','active'=>1],
            ['id'=>2,'module_id'=>1,'name'=>'modulos','active'=>1],
            ['id'=>3,'module_id'=>1,'name'=>'roles','active'=>1],

            ['id'=>5,'module_id'=>2,'name'=>'stock','active'=>1],
            ['id'=>6,'module_id'=>2,'name'=>'clasificaciones','active'=>1],
            ['id'=>7,'module_id'=>2,'name'=>'depositos','active'=>1],
            ['id'=>8,'module_id'=>2,'name'=>'productos','active'=>1],

            ['id'=>9,'module_id'=>3,'name'=>'clientes','active'=>1],

            ['id'=>10,'module_id'=>4,'name'=>'mesas','active'=>1],

            ['id'=>11,'module_id'=>5,'name'=>'cajas','active'=>1],

        ]);


        /*
        |---------------------------------------
        | ROLES
        |---------------------------------------
        */

        DB::table('roles')->insert([

            [
                'id'=>1,
                'name'=>'superadmin',
                'guard_name'=>'web'
            ],

            [
                'id'=>2,
                'name'=>'solousuarios',
                'guard_name'=>'web'
            ],

        ]);


        /*
        |---------------------------------------
        | PERMISSIONS
        |---------------------------------------
        */

        DB::table('permissions')->insert([

            ['id'=>5,'name'=>'administrador.modulos.index','guard_name'=>'web','module_id'=>1,'submodule_id'=>2],
            ['id'=>6,'name'=>'administrador.modulos.create','guard_name'=>'web','module_id'=>1,'submodule_id'=>2],
            ['id'=>7,'name'=>'administrador.modulos.edit','guard_name'=>'web','module_id'=>1,'submodule_id'=>2],
            ['id'=>8,'name'=>'administrador.modulos.delete','guard_name'=>'web','module_id'=>1,'submodule_id'=>2],

            ['id'=>9,'name'=>'administrador.roles.index','guard_name'=>'web','module_id'=>1,'submodule_id'=>3],
            ['id'=>10,'name'=>'administrador.roles.create','guard_name'=>'web','module_id'=>1,'submodule_id'=>3],
            ['id'=>11,'name'=>'administrador.roles.edit','guard_name'=>'web','module_id'=>1,'submodule_id'=>3],
            ['id'=>12,'name'=>'administrador.roles.delete','guard_name'=>'web','module_id'=>1,'submodule_id'=>3],

            ['id'=>13,'name'=>'administrador.usuarios.index','guard_name'=>'web','module_id'=>1,'submodule_id'=>1],
            ['id'=>14,'name'=>'administrador.usuarios.create','guard_name'=>'web','module_id'=>1,'submodule_id'=>1],
            ['id'=>15,'name'=>'administrador.usuarios.edit','guard_name'=>'web','module_id'=>1,'submodule_id'=>1],
            ['id'=>16,'name'=>'administrador.usuarios.delete','guard_name'=>'web','module_id'=>1,'submodule_id'=>1],

            ['id'=>17,'name'=>'productos.stock.index','guard_name'=>'web','module_id'=>2,'submodule_id'=>5],
            ['id'=>18,'name'=>'productos.stock.create','guard_name'=>'web','module_id'=>2,'submodule_id'=>5],
            ['id'=>19,'name'=>'productos.stock.edit','guard_name'=>'web','module_id'=>2,'submodule_id'=>5],
            ['id'=>20,'name'=>'productos.stock.delete','guard_name'=>'web','module_id'=>2,'submodule_id'=>5],

            ['id'=>21,'name'=>'productos.clasificaciones.index','guard_name'=>'web','module_id'=>2,'submodule_id'=>6],
            ['id'=>22,'name'=>'productos.clasificaciones.create','guard_name'=>'web','module_id'=>2,'submodule_id'=>6],
            ['id'=>23,'name'=>'productos.clasificaciones.edit','guard_name'=>'web','module_id'=>2,'submodule_id'=>6],
            ['id'=>24,'name'=>'productos.clasificaciones.delete','guard_name'=>'web','module_id'=>2,'submodule_id'=>6],

            ['id'=>25,'name'=>'productos.depositos.index','guard_name'=>'web','module_id'=>2,'submodule_id'=>7],
            ['id'=>26,'name'=>'productos.depositos.create','guard_name'=>'web','module_id'=>2,'submodule_id'=>7],
            ['id'=>27,'name'=>'productos.depositos.edit','guard_name'=>'web','module_id'=>2,'submodule_id'=>7],
            ['id'=>28,'name'=>'productos.depositos.delete','guard_name'=>'web','module_id'=>2,'submodule_id'=>7],

            ['id'=>29,'name'=>'productos.productos.index','guard_name'=>'web','module_id'=>2,'submodule_id'=>8],
            ['id'=>30,'name'=>'productos.productos.create','guard_name'=>'web','module_id'=>2,'submodule_id'=>8],
            ['id'=>31,'name'=>'productos.productos.edit','guard_name'=>'web','module_id'=>2,'submodule_id'=>8],
            ['id'=>32,'name'=>'productos.productos.delete','guard_name'=>'web','module_id'=>2,'submodule_id'=>8],

            ['id'=>33,'name'=>'clientes.clientes.index','guard_name'=>'web','module_id'=>3,'submodule_id'=>9],
            ['id'=>34,'name'=>'clientes.clientes.create','guard_name'=>'web','module_id'=>3,'submodule_id'=>9],
            ['id'=>35,'name'=>'clientes.clientes.edit','guard_name'=>'web','module_id'=>3,'submodule_id'=>9],
            ['id'=>36,'name'=>'clientes.clientes.delete','guard_name'=>'web','module_id'=>3,'submodule_id'=>9],

            ['id'=>37,'name'=>'mesas.mesas.index','guard_name'=>'web','module_id'=>4,'submodule_id'=>10],
            ['id'=>38,'name'=>'mesas.mesas.create','guard_name'=>'web','module_id'=>4,'submodule_id'=>10],
            ['id'=>39,'name'=>'mesas.mesas.edit','guard_name'=>'web','module_id'=>4,'submodule_id'=>10],
            ['id'=>40,'name'=>'mesas.mesas.delete','guard_name'=>'web','module_id'=>4,'submodule_id'=>10],

            ['id'=>41,'name'=>'ventas.cajas.index','guard_name'=>'web','module_id'=>5,'submodule_id'=>11],
            ['id'=>42,'name'=>'ventas.cajas.create','guard_name'=>'web','module_id'=>5,'submodule_id'=>11],
            ['id'=>43,'name'=>'ventas.cajas.edit','guard_name'=>'web','module_id'=>5,'submodule_id'=>11],
            ['id'=>44,'name'=>'ventas.cajas.delete','guard_name'=>'web','module_id'=>5,'submodule_id'=>11],

        ]);


        /*
        |---------------------------------------
        | ROLE PERMISSIONS (SUPERADMIN)
        |---------------------------------------
        */

        for ($i=5;$i<=44;$i++){

            DB::table('role_has_permissions')->insert([
                'permission_id'=>$i,
                'role_id'=>1
            ]);

        }


        /*
        |---------------------------------------
        | USER ROLES
        |---------------------------------------
        */

        DB::table('model_has_roles')->insert([
            [
                'role_id'=>1,
                'model_type'=>'App\Models\User',
                'model_id'=>1
            ]
        ]);

    }
}
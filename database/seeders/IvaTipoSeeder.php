<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\IvaTipo;

class IvaTipoSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */


    public function run()
    {
        IvaTipo::create([
            'nombre' => 'IVA 10%',
            'porcentaje' => 10
        ]);

        IvaTipo::create([
            'nombre' => 'IVA 5%',
            'porcentaje' => 5
        ]);

        IvaTipo::create([
            'nombre' => 'Exento',
            'porcentaje' => 0
        ]);
    }
}

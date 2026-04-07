<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up()
    {
        DB::statement("ALTER TABLE ventas MODIFY estado ENUM('abierta','en_proceso','cerrada','cancelada')");

        Schema::table('ventas', function (Blueprint $table) {
            $table->enum('estado_pago', ['pendiente','parcial','pagado'])
                ->default('pendiente')
                ->after('estado');
        });
    }

    public function down()
    {
        DB::statement("ALTER TABLE ventas MODIFY estado ENUM('abierta','en_proceso','pagada','cancelada')");

        Schema::table('ventas', function (Blueprint $table) {
            $table->dropColumn('estado_pago');
        });
    }


};

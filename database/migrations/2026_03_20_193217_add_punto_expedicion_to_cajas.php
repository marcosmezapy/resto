<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{

    public function up()
    {
        Schema::table('cajas', function (Blueprint $table) {
            $table->foreignId('punto_expedicion_id')
                ->nullable()
                ->after('sucursal_id')
                ->constrained('puntos_expediciones');
        });
    }

    public function down()
    {
        Schema::table('cajas', function (Blueprint $table) {
            $table->dropForeign(['punto_expedicion_id']);
            $table->dropColumn('punto_expedicion_id');
        });
    }

};

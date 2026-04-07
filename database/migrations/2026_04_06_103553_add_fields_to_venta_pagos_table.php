<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('venta_pagos', function (Blueprint $table) {

            $table->unsignedBigInteger('user_id')
                ->nullable()
                ->after('venta_id');

            $table->string('referencia')
                ->nullable()
                ->after('metodo_pago');

            $table->string('observacion')
                ->nullable()
                ->after('referencia');

            // 🔗 FK (opcional pero recomendado)
            $table->foreign('user_id')
                ->references('id')
                ->on('users')
                ->nullOnDelete();
        });
    }

    public function down(): void
    {
        Schema::table('venta_pagos', function (Blueprint $table) {

            $table->dropForeign(['user_id']);

            $table->dropColumn([
                'user_id',
                'referencia',
                'observacion'
            ]);
        });
    }
};


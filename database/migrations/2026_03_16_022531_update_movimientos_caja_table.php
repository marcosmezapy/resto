<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('movimientos_caja', function (Blueprint $table) {

            $table->foreignId('user_id')
                ->after('caja_sesion_id')
                ->constrained('users');

            $table->unsignedBigInteger('referencia_id')
                ->nullable()
                ->after('monto');
        });
    }

    public function down(): void
    {
        Schema::table('movimientos_caja', function (Blueprint $table) {

            $table->dropColumn('user_id');
            $table->dropColumn('referencia_id');

        });
    }
};
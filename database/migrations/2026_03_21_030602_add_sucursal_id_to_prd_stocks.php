<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::table('prd_stocks', function (Blueprint $table) {

            // 1. CREAR COLUMNA
            $table->unsignedBigInteger('sucursal_id')->after('tenant_id');

            // 2. FOREIGN KEY
            $table->foreign('sucursal_id')
                ->references('id')
                ->on('sucursales')
                ->onDelete('cascade');

        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('prd_stocks', function (Blueprint $table) {
            //
        });
    }
};

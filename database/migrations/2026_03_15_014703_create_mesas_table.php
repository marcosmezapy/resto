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
        Schema::create('mesas', function (Blueprint $table) {

            $table->id();

            $table->string('numero');     // Mesa 1, Mesa 2
            $table->integer('capacidad')->default(4);
            $table->boolean('activa')->default(true);

            // Para el POS
            $table->boolean('ocupada')->default(false);

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('mesas');
    }
};

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
        Schema::create('caja_sesiones', function (Blueprint $table) {

            $table->id();

            $table->foreignId('caja_id')
                ->constrained('cajas')
                ->cascadeOnDelete();

            $table->foreignId('usuario_id')
                ->constrained('users')
                ->cascadeOnDelete();

            $table->decimal('monto_apertura',10,2);

            $table->decimal('monto_cierre',10,2)->nullable();

            $table->timestamp('fecha_apertura');

            $table->timestamp('fecha_cierre')->nullable();

            $table->enum('estado',['abierta','cerrada'])
                ->default('abierta');

            $table->timestamps();

        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('caja_sesiones');
    }
};

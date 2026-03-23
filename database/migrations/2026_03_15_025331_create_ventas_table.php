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
        Schema::create('ventas', function (Blueprint $table) {

            $table->id();

            $table->foreignId('caja_sesion_id')
                ->constrained('caja_sesiones');

            $table->foreignId('mesa_id')
                ->nullable()
                ->constrained('mesas');

            $table->foreignId('cliente_id')
                ->nullable()
                ->constrained('clientes')
                ->default(1);
            $table->foreignId('usuario_id')
                ->constrained('users');

            $table->decimal('total',10,2)->default(0);

            $table->enum('estado',[
                'abierta',
                'en_proceso',
                'pagada',
                'cancelada'
            ])->default('abierta');

            $table->timestamps();

        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('ventas');
    }
};

<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('timbrados', function (Blueprint $table) {
            $table->id();

            $table->foreignId('tenant_id')->constrained()->cascadeOnDelete();
            $table->foreignId('sucursal_id')->constrained('sucursales')->cascadeOnDelete();
            $table->foreignId('punto_expedicion_id')->constrained('puntos_expediciones')->cascadeOnDelete();

            $table->string('numero_timbrado');

            $table->date('fecha_inicio');
            $table->date('fecha_fin');

            $table->unsignedBigInteger('numero_inicio');
            $table->unsignedBigInteger('numero_fin');
            $table->unsignedBigInteger('ultimo_numero_usado')->default(0);

            $table->enum('estado', ['vigente', 'agotado', 'vencido'])->default('vigente');
            $table->boolean('activo')->default(true);

            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('timbrados');
    }
};
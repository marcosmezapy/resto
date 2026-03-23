<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('numeraciones', function (Blueprint $table) {
            $table->id();

            $table->unsignedBigInteger('tenant_id');
            $table->unsignedBigInteger('sucursal_id');
            $table->unsignedBigInteger('punto_expedicion_id');

            $table->bigInteger('ultimo_numero')->default(0);

            $table->timestamps();

            $table->unique([
                'tenant_id',
                'sucursal_id',
                'punto_expedicion_id'
            ], 'unique_numeracion');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('numeraciones');
    }
};
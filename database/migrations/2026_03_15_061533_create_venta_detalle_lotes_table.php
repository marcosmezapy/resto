<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{

    public function up(): void
    {

        Schema::create('venta_detalle_lotes', function (Blueprint $table) {

            $table->id();

            $table->foreignId('venta_detalle_id')
                ->constrained('venta_detalles')
                ->cascadeOnDelete();

            $table->foreignId('stock_id')
                ->constrained('prd_stocks')
                ->cascadeOnDelete();

            $table->integer('cantidad');

            $table->decimal('costo_unitario',12,2);

            $table->timestamps();

        });

    }


    public function down(): void
    {
        Schema::dropIfExists('venta_detalle_lotes');
    }

};
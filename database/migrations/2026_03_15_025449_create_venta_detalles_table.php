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
Schema::create('venta_detalles', function (Blueprint $table) {

    $table->id();

    $table->foreignId('venta_id')
        ->constrained('ventas')
        ->cascadeOnDelete();

    $table->foreignId('producto_id')
        ->constrained('prd_productos');

    $table->decimal('precio',10,2);

    $table->integer('cantidad');

    $table->decimal('subtotal',10,2);

    $table->timestamps();
});
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('venta_detalles');
    }
};

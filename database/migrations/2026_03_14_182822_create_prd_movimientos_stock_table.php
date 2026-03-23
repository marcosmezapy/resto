<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('prd_movimientos_stock', function (Blueprint $table) {

            $table->id();

            $table->foreignId('producto_id')
                  ->constrained('prd_productos')
                  ->cascadeOnDelete();

            $table->foreignId('deposito_id')
                  ->constrained('prd_depositos')
                  ->cascadeOnDelete();

            $table->enum('tipo', [
                'entrada',
                'salida',
                'transferencia',
                'ajuste'
            ]);

            $table->integer('cantidad');

            $table->decimal('costo_unitario',12,2)->nullable();

            $table->string('lote')->nullable();

            $table->text('descripcion')->nullable();

            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('prd_movimientos_stock');
    }
};
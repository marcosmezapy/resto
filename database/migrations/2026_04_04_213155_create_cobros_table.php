<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up()
    {
        Schema::create('cobros', function (Blueprint $table) {

            $table->id();

            $table->foreignId('venta_id')->constrained()->cascadeOnDelete();

            $table->foreignId('cliente_id')->constrained()->cascadeOnDelete();

            $table->decimal('monto', 12, 2);

            $table->string('metodo_pago');

            $table->foreignId('user_id')->nullable();

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('cobros');
    }
};

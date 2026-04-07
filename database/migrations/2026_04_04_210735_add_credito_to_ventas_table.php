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
        Schema::table('ventas', function (Blueprint $table) {

            $table->enum('condicion_pago', ['contado','credito'])->default('contado');

            $table->decimal('saldo', 12, 2)->default(0);

            $table->integer('dias_credito')->nullable();

            $table->date('fecha_vencimiento')->nullable();

        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('ventas', function (Blueprint $table) {
            //
        });
    }
};

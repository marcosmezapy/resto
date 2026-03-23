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
        Schema::table('venta_detalles', function (Blueprint $table) {

            // 🆕 porcentaje aplicado en el momento de la venta
            $table->decimal('iva_porcentaje', 5, 2)->default(0)->after('precio');

            // 🆕 monto de IVA por unidad
            $table->decimal('iva_unitario', 12, 2)->default(0)->after('iva_porcentaje');

            // 🆕 monto total de IVA de la línea
            $table->decimal('iva_total', 12, 2)->default(0)->after('subtotal');

        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('venta_detalles', function (Blueprint $table) {
            //
        });
    }
};

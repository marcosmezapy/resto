<?php
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('venta_detalles', function (Blueprint $table) {

            $table->decimal('precio_original',10,2)->nullable()->after('precio');

            $table->decimal('descuento_porcentaje',5,2)
                ->default(0)
                ->after('precio_original');

            $table->decimal('subtotal_original',10,2)
                ->nullable()
                ->after('subtotal');

            $table->decimal('iva_original',12,2)
                ->nullable()
                ->after('iva_total');

        });
    }

    public function down(): void
    {
        Schema::table('venta_detalles', function (Blueprint $table) {

            $table->dropColumn([
                'precio_original',
                'descuento_porcentaje',
                'subtotal_original',
                'iva_original'
            ]);

        });
    }
};
<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('ventas', function (Blueprint $table) {
            $table->foreignId('sucursal_id')->after('tenant_id')->constrained('sucursales');
            $table->foreignId('punto_expedicion_id')->nullable()->constrained('puntos_expediciones');
            $table->foreignId('timbrado_id')->nullable()->constrained();

            $table->string('numero_factura')->nullable();
        });
    }

    public function down(): void
    {
        Schema::table('ventas', function (Blueprint $table) {
            $table->dropForeign(['sucursal_id']);
            $table->dropForeign(['punto_expedicion_id']);
            $table->dropForeign(['timbrado_id']);

            $table->dropColumn([
                'sucursal_id',
                'punto_expedicion_id',
                'timbrado_id',
                'numero_factura'
            ]);
        });
    }
};
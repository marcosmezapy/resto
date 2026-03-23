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
    Schema::table('prd_productos', function (Blueprint $table) {
        $table->decimal('costo_base',12,2)->nullable()->after('es_stockeable');
        $table->decimal('precio_venta',12,2)->nullable()->after('costo_base');
    });
}

public function down(): void
{
    Schema::table('prd_productos', function (Blueprint $table) {
        $table->dropColumn(['costo_base','precio_venta']);
    });
}
};

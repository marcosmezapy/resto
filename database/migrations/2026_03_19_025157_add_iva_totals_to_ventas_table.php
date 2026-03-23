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
        Schema::table('ventas', function (Blueprint $table) {

            $table->decimal('total_iva', 12, 2)->default(0)->after('total');

            $table->decimal('total_gravada_10', 12, 2)->default(0);
            $table->decimal('total_gravada_5', 12, 2)->default(0);
            $table->decimal('total_exenta', 12, 2)->default(0);

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

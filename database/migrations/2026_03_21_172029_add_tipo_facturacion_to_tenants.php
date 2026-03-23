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
        Schema::table('tenants', function (Blueprint $table) {

            $table->enum('tipo_facturacion', ['formal','informal'])
                ->default('formal')
                ->after('email'); // podés cambiar la posición si querés

        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('tenants', function (Blueprint $table) {

            $table->dropColumn('tipo_facturacion');

        });
    }
};
<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('tenants', function (Blueprint $table) {

            // 🆕 DATOS EMPRESA
            $table->string('razon_social')->nullable()->after('nombre');
            $table->string('ruc')->nullable()->after('razon_social');
            $table->string('direccion')->nullable()->after('ruc');
            $table->string('telefono')->nullable()->after('direccion');
            $table->string('email')->nullable()->after('telefono');

            // 🆕 VISUAL / TICKET
            $table->string('logo')->nullable()->after('email');
            $table->text('mensaje_ticket')->nullable()->after('logo');

        });
    }

    public function down(): void
    {
        Schema::table('tenants', function (Blueprint $table) {

            $table->dropColumn([
                'razon_social',
                'ruc',
                'direccion',
                'telefono',
                'email',
                'logo',
                'mensaje_ticket'
            ]);

        });
    }
};
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
        Schema::create('iva_tipos', function (Blueprint $table) {
            $table->id();
            $table->string('nombre'); // IVA 10%, IVA 5%, Exento
            $table->decimal('porcentaje', 5, 2); // 10, 5, 0
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('iva_tipos');
    }
};

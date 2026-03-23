<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePrdProductosTable extends Migration
{
    public function up()
    {
        Schema::create('prd_productos', function (Blueprint $table) {
            $table->id();
            $table->string('nombre');
            $table->string('sku')->unique();
            $table->text('descripcion')->nullable();
            $table->boolean('es_stockeable')->default(true);
            $table->foreignId('clasificacion_id')->constrained('prd_clasificaciones')->onDelete('cascade');
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('prd_productos');
    }
}
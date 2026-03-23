<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePrdStocksTable extends Migration
{
    public function up()
    {
        Schema::create('prd_stocks', function (Blueprint $table) {
            $table->id();
            $table->foreignId('producto_id')->constrained('prd_productos')->onDelete('cascade');
            $table->foreignId('deposito_id')->constrained('prd_depositos')->onDelete('cascade');
            $table->string('lote');
            $table->date('fecha_ingreso');
            $table->integer('cantidad')->default(0);
            $table->decimal('costo_compra', 12,2);
        //    $table->decimal('costo_venta', 12,2);
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('prd_stocks');
    }
}
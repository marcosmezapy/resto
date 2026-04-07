<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    public function up(): void
    {
        DB::statement("
            ALTER TABLE ventas 
            MODIFY estado_pago ENUM('pendiente','parcial','pagado','cancelado')
        ");
    }

    public function down(): void
    {
        DB::statement("
            ALTER TABLE ventas 
            MODIFY estado_pago ENUM('pendiente','parcial','pagado')
        ");
    }
};
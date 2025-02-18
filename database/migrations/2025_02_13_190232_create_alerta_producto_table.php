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
        Schema::create('alerta_producto', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->unsignedBigInteger('Id_ProductoFK')->index('alerta_producto_id_productofk_foreign');
            $table->unsignedBigInteger('Id_AlertaFK')->index('alerta_producto_id_alertafk_foreign');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('alerta_producto');
    }
};

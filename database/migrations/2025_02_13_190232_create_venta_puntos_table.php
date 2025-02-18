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
        Schema::create('venta_puntos', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->unsignedBigInteger('Id_PuntosFK')->index('venta_puntos_id_puntosfk_foreign');
            $table->unsignedBigInteger('Id_VentaFK')->index('venta_puntos_id_ventafk_foreign');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('venta_puntos');
    }
};

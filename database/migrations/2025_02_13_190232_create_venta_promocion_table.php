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
        Schema::create('venta_promocion', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->unsignedBigInteger('Id_PromocionFK')->index('venta_promocion_id_promocionfk_foreign');
            $table->unsignedBigInteger('Id_VentaFK')->index('venta_promocion_id_ventafk_foreign');
            $table->unsignedBigInteger('Id_ReporteFK')->index('venta_promocion_id_reportefk_foreign');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('venta_promocion');
    }
};

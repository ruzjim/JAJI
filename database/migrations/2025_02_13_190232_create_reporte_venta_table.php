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
        Schema::create('reporte_venta', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->unsignedBigInteger('Id_VentaFK')->index('reporte_venta_id_ventafk_foreign');
            $table->unsignedBigInteger('Id_ReporteFK')->index('reporte_venta_id_reportefk_foreign');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('reporte_venta');
    }
};

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
        Schema::create('reporte_producto', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->unsignedBigInteger('Id_ProductoFK')->index('reporte_producto_id_productofk_foreign');
            $table->unsignedBigInteger('Id_ReporteFK')->index('reporte_producto_id_reportefk_foreign');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('reporte_producto');
    }
};

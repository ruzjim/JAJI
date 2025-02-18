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
        Schema::table('venta_promocion', function (Blueprint $table) {
            $table->foreign(['Id_PromocionFK'])->references(['Id_Promocion'])->on('promocion')->onUpdate('restrict')->onDelete('no action');
            $table->foreign(['Id_ReporteFK'])->references(['Id_Reporte'])->on('reporte')->onUpdate('restrict')->onDelete('no action');
            $table->foreign(['Id_VentaFK'])->references(['Id_Venta'])->on('venta')->onUpdate('restrict')->onDelete('no action');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('venta_promocion', function (Blueprint $table) {
            $table->dropForeign('venta_promocion_id_promocionfk_foreign');
            $table->dropForeign('venta_promocion_id_reportefk_foreign');
            $table->dropForeign('venta_promocion_id_ventafk_foreign');
        });
    }
};

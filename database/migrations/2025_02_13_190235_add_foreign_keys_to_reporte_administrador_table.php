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
        Schema::table('reporte_administrador', function (Blueprint $table) {
            $table->foreign(['Id_AdministradorFK'])->references(['Id_Administrador'])->on('administrador')->onUpdate('restrict')->onDelete('no action');
            $table->foreign(['Id_ReporteFK'])->references(['Id_Reporte'])->on('reporte')->onUpdate('restrict')->onDelete('no action');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('reporte_administrador', function (Blueprint $table) {
            $table->dropForeign('reporte_administrador_id_administradorfk_foreign');
            $table->dropForeign('reporte_administrador_id_reportefk_foreign');
        });
    }
};

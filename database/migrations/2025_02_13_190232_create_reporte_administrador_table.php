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
        Schema::create('reporte_administrador', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->unsignedBigInteger('Id_AdministradorFK')->index('reporte_administrador_id_administradorfk_foreign');
            $table->unsignedBigInteger('Id_ReporteFK')->index('reporte_administrador_id_reportefk_foreign');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('reporte_administrador');
    }
};

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
        Schema::table('venta_puntos', function (Blueprint $table) {
            $table->foreign(['Id_PuntosFK'])->references(['Id_Puntos'])->on('puntos')->onUpdate('restrict')->onDelete('no action');
            $table->foreign(['Id_VentaFK'])->references(['Id_Venta'])->on('venta')->onUpdate('restrict')->onDelete('no action');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('venta_puntos', function (Blueprint $table) {
            $table->dropForeign('venta_puntos_id_puntosfk_foreign');
            $table->dropForeign('venta_puntos_id_ventafk_foreign');
        });
    }
};

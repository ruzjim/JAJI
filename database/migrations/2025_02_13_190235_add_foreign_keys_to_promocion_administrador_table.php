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
        Schema::table('promocion_administrador', function (Blueprint $table) {
            $table->foreign(['Id_AdministradorFK'])->references(['Id_Administrador'])->on('administrador')->onUpdate('restrict')->onDelete('no action');
            $table->foreign(['Id_PromocionFK'])->references(['Id_Promocion'])->on('promocion')->onUpdate('restrict')->onDelete('no action');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('promocion_administrador', function (Blueprint $table) {
            $table->dropForeign('promocion_administrador_id_administradorfk_foreign');
            $table->dropForeign('promocion_administrador_id_promocionfk_foreign');
        });
    }
};

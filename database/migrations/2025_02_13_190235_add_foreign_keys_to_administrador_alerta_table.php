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
        Schema::table('administrador_alerta', function (Blueprint $table) {
            $table->foreign(['Id_AdministradorFK'])->references(['Id_Administrador'])->on('administrador')->onUpdate('restrict')->onDelete('no action');
            $table->foreign(['Id_AlertaFK'])->references(['Id_Alerta'])->on('alerta')->onUpdate('restrict')->onDelete('no action');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('administrador_alerta', function (Blueprint $table) {
            $table->dropForeign('administrador_alerta_id_administradorfk_foreign');
            $table->dropForeign('administrador_alerta_id_alertafk_foreign');
        });
    }
};

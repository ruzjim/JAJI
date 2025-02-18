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
        Schema::table('comentario_administrador', function (Blueprint $table) {
            $table->foreign(['Id_AdministradorFK'])->references(['Id_Administrador'])->on('administrador')->onUpdate('restrict')->onDelete('no action');
            $table->foreign(['Id_ComentarioFK'])->references(['Id_Comentario'])->on('comentario')->onUpdate('restrict')->onDelete('no action');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('comentario_administrador', function (Blueprint $table) {
            $table->dropForeign('comentario_administrador_id_administradorfk_foreign');
            $table->dropForeign('comentario_administrador_id_comentariofk_foreign');
        });
    }
};

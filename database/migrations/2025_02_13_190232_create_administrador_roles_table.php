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
        Schema::create('administrador_roles', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->unsignedBigInteger('Id_AdministradorFK')->index('administrador_roles_id_administradorfk_foreign');
            $table->unsignedBigInteger('Id_RolFK')->index('administrador_roles_id_rolfk_foreign');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('administrador_roles');
    }
};

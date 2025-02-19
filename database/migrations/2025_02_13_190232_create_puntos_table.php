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
        Schema::create('puntos', function (Blueprint $table) {
            $table->bigIncrements('Id_Puntos');
            $table->string('Nombre_Punto', 100);
            $table->timestamps();
            $table->integer('Puntos_Obtenitos')->nullable();
            $table->tinyInteger('Estado')->default(1);
            $table->string('Descripcion', 300);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('puntos');
    }
};

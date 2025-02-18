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
        Schema::create('producto', function (Blueprint $table) {
            $table->bigIncrements('Id_Producto');
            $table->string('Nombre_Producto', 100);
            $table->string('Marca', 100);
            $table->integer('Stock')->nullable();
            $table->string('Descripcion', 300);
            $table->decimal('Precio_Original', 7);
            $table->decimal('Precio_Modificado', 7);
            $table->timestamps();
            $table->string('ubicacion')->nullable()->default('No disponible');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('producto');
    }
};

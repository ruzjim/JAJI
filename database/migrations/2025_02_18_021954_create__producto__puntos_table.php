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
        Schema::create('producto_puntos', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('Id_ProductoFK');
            $table->unsignedBigInteger('Id_PuntosFK');
            $table->tinyInteger('Estado')->default(1);
            $table->timestamps();
            $table->foreign('Id_ProductoFK')->references('Id_Producto')->on('producto')->onDelete('no action')->onUpdate('restrict');
            $table->foreign('Id_PuntosFK')->references('Id_Puntos')->on('puntos')->onDelete('no action')->onUpdate('restrict');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('_producto__puntos');
    }
};

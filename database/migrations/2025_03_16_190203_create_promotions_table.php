<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePromotionsTable extends Migration
{
    public function up()
    {
        Schema::create('promotions', function (Blueprint $table) {
            $table->id();
            $table->string('title');  // Título de la promoción
            $table->text('description');  // Descripción de la promoción
            $table->string('image');  // Ruta de la imagen del banner
            $table->boolean('is_active')->default(true);  // Si la promoción está activa
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('promotions');
    }
}

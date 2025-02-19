<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up()
    {
        Schema::create('puntos_users', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('Id_UsersFK');
            $table->unsignedBigInteger('Id_PuntosFK');
            $table->timestamps();
    
            $table->foreign('Id_UsersFK')->references('id')->on('users')->onDelete('no action')->onUpdate('restrict');
            $table->foreign('Id_PuntosFK')->references('Id_Puntos')->on('puntos')->onDelete('no action')->onUpdate('restrict');
        });
    }
    
};
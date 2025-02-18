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
        Schema::create('venta', function (Blueprint $table) {
            $table->bigIncrements('Id_Venta');
            $table->decimal('Monto_Total', 7);
            $table->timestamps();
            $table->unsignedBigInteger('Id_PagoFK')->index('venta_id_pagofk_foreign');
            $table->unsignedBigInteger('Id_ClienteFK')->index('venta_id_clientefk_foreign');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('venta');
    }
};

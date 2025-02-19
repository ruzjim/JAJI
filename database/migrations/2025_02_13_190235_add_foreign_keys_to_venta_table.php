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
        Schema::table('venta', function (Blueprint $table) {
            $table->foreign(['Id_ClienteFK'])->references(['Id_Cliente'])->on('users')->onUpdate('restrict')->onDelete('no action');
            $table->foreign(['Id_PagoFK'])->references(['Id_Pago'])->on('pago')->onUpdate('restrict')->onDelete('no action');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('venta', function (Blueprint $table) {
            $table->dropForeign('venta_id_clientefk_foreign');
            $table->dropForeign('venta_id_pagofk_foreign');
        });
    }
};

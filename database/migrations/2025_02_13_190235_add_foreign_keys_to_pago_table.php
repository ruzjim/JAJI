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
        Schema::table('pago', function (Blueprint $table) {
            $table->foreign(['Id_ClienteFK'])->references(['Id_Cliente'])->on('clientes')->onUpdate('restrict')->onDelete('no action');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('pago', function (Blueprint $table) {
            $table->dropForeign('pago_id_clientefk_foreign');
        });
    }
};

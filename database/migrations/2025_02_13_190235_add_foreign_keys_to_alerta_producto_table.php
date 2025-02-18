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
        Schema::table('alerta_producto', function (Blueprint $table) {
            $table->foreign(['Id_AlertaFK'])->references(['Id_Alerta'])->on('alerta')->onUpdate('restrict')->onDelete('no action');
            $table->foreign(['Id_ProductoFK'])->references(['Id_Producto'])->on('producto')->onUpdate('restrict')->onDelete('no action');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('alerta_producto', function (Blueprint $table) {
            $table->dropForeign('alerta_producto_id_alertafk_foreign');
            $table->dropForeign('alerta_producto_id_productofk_foreign');
        });
    }
};

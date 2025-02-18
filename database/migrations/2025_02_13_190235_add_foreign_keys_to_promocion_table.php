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
        Schema::table('promocion', function (Blueprint $table) {
            $table->foreign(['Id_ProductoFK'])->references(['Id_Producto'])->on('producto')->onUpdate('restrict')->onDelete('no action');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('promocion', function (Blueprint $table) {
            $table->dropForeign('promocion_id_productofk_foreign');
        });
    }
};

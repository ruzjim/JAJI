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
        Schema::create('productos_categoria', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->unsignedBigInteger('Id_ProductoFK')->index('productos_categoria_id_productofk_foreign');
            $table->unsignedBigInteger('Id_VentaFK')->index('productos_categoria_id_ventafk_foreign');
            $table->unsignedBigInteger('Id_CategoriaFK')->index('productos_categoria_id_categoriafk_foreign');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('productos_categoria');
    }
};

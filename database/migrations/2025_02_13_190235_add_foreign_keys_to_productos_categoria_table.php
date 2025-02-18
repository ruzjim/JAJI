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
        Schema::table('productos_categoria', function (Blueprint $table) {
            $table->foreign(['Id_CategoriaFK'])->references(['Id_Categoria'])->on('categoria')->onUpdate('restrict')->onDelete('no action');
            $table->foreign(['Id_ProductoFK'])->references(['Id_Producto'])->on('producto')->onUpdate('restrict')->onDelete('no action');
            $table->foreign(['Id_VentaFK'])->references(['Id_Venta'])->on('venta')->onUpdate('restrict')->onDelete('no action');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('productos_categoria', function (Blueprint $table) {
            $table->dropForeign('productos_categoria_id_categoriafk_foreign');
            $table->dropForeign('productos_categoria_id_productofk_foreign');
            $table->dropForeign('productos_categoria_id_ventafk_foreign');
        });
    }
};

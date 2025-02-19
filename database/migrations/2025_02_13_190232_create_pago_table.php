<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
        public function up(): void
        {
            Schema::table('pago', function (Blueprint $table) {
                $table->dropForeign('pago_id_clientefk_foreign');
    
                $table->unsignedBigInteger('Id_ClienteFK')->change();
    
                $table->foreign('Id_ClienteFK')
                      ->references('id') 
                      ->on('users')
                      ->onDelete('cascade') 
                      ->onUpdate('cascade'); 
            });
        }
    
        public function down(): void
        {
            Schema::table('pago', function (Blueprint $table) {
              
                $table->dropForeign(['Id_ClienteFK']);
                $table->foreign('Id_ClienteFK')
                      ->references('Id_Cliente')
                      ->on('clientes')
                      ->onDelete('no action')
                      ->onUpdate('no action');
            });
        }
};

<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class punto extends Model
{
    /** @use HasFactory<\Database\Factories\UserFactory> */
    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */

     protected $table = 'puntos';
     protected $primaryKey = 'Id_Puntos';
     protected $fillable = [
         'Nombre_Punto',
         'Puntos_Obtenidos',
         'Estado',
         'Descripcion',
         
     ];
 
     public $timestamps = true;

     public function productoPuntos()
     {
         return $this->hasMany(ProductoPunto::class, 'Id_PuntosFK', 'Id_Puntos');
     }
}

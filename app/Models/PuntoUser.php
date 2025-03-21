<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PuntoUser extends Model
{
    use HasFactory;

    protected $table = 'puntos_users';
    protected $primaryKey = 'id';
    public $timestamps = true;

    protected $fillable = ['Id_UsersFK', 'Id_PuntosFK'];
}

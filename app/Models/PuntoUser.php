<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Relations\Pivot; // Cambia esta línea
use Illuminate\Database\Eloquent\Factories\HasFactory;

class PuntoUser extends Pivot // Cambia la herencia
{
    use HasFactory;

    protected $table = 'puntos_users';
    public $timestamps = true; // Mantén esto si tu tabla tiene timestamps

    protected $fillable = [
        'Id_UsersFK', 
        'Id_PuntosFK', 
        'Fecha_De_Caducidad', 
        'Estado'
    ];

    public function user()
    {
        return $this->belongsTo(User::class, 'Id_UsersFK');
    }

    public function punto()
    {
        return $this->belongsTo(punto::class, 'Id_PuntosFK');
    }
}
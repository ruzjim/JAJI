<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;

class User extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'id',
        'role_id',
        'profile_photo_path',
        'name',
        'cedula',
        'telefono',
        'email',
        'password',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
        'password' => 'hashed',
    ];

    public function pagos()
    {
        return $this->hasMany(Pago::class, 'Id_ClienteFK');
    }

    public function puntos()
{
    return $this->belongsToMany(Punto::class, 'puntos_users', 'Id_UsersFK', 'Id_PuntosFK')
             ->using(PuntoUser::class)
             ->withPivot('Fecha_De_Caducidad', 'Estado')
             ->withTimestamps(); // Si tu tabla tiene timestamps
}

public function puntosAcumulados()
{
    return $this->hasMany(PuntoUser::class, 'Id_UsersFK');
}


}

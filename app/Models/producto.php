<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Fortify\TwoFactorAuthenticatable;

class producto extends model
{

    /** @use HasFactory<\Database\Factories\UserFactory> */
    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */

    protected $table = 'producto';
    protected $primaryKey = 'Id_Producto';
    protected $fillable = [
        'Nombre_Producto',
        'Marca',
        'Stock',
        'Descripcion',
        'Precio_Compra',
        'Precio_Venta',
        'ubicacion',
        'Estado',
    ];

    public $timestamps = true;

    public function productoPuntos()
    {
        return $this->hasMany(ProductoPunto::class, 'Id_ProductoFK', 'Id_Producto');
    }
}
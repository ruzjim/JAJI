<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Fortify\TwoFactorAuthenticatable;

class Producto extends model
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
        'Fecha_De_Caducidad',
        'ubicacion',
        'Estado',
        'Expirado'
    ];

    public $timestamps = true;

    public function productoPuntos()
    {
        return $this->hasMany(ProductoPunto::class, 'Id_ProductoFK', 'Id_Producto');
    }

    protected static function boot()
    {
        parent::boot();
    
        static::updating(function ($producto) {
            // Si el stock llega a 0, cambiar estado a Inactivo (0)
            if ($producto->Stock <= 0) {
                $producto->Estado = 0;
            }
        });
    }

}
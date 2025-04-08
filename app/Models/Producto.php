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
        'barcode',
        'Nombre_Producto',
        'Marca',
        'imagen',
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
    
        static::saving(function ($producto) {
            // Calcular Expirado
            if ($producto->Fecha_De_Caducidad) {
                $fechaCaducidad = \Carbon\Carbon::parse($producto->Fecha_De_Caducidad);
                $producto->Expirado = $fechaCaducidad->isPast() ? 1 : 0;
            } else {
                $producto->Expirado = 0;
            }
    
            // Calcular Estado
            if ($producto->Expirado == 1 || $producto->Stock <= 0) {
                $producto->Estado = 0;
            }
        });
    }

}
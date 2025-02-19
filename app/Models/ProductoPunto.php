<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ProductoPunto extends Model
{
    use HasFactory;

    protected $table = 'producto_puntos';

    protected $fillable = [
        'Id_ProductoFK',
        'Id_PuntosFK',
        'Estado',
    ];

    public $timestamps = true;

    public function producto()
    {
        return $this->belongsTo(Producto::class, 'Id_ProductoFK', 'Id_Producto');
    }

    public function punto()
    {
        return $this->belongsTo(Punto::class, 'Id_PuntosFK', 'Id_Puntos');
    }
}

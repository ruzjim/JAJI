<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class VentaProducto extends Model
{
    use HasFactory;

    protected $table = 'venta_productos';

    protected $fillable = [
        'Id_VentaFK',
        'Id_ProductoFK',
    ];

    public $timestamps = true;

    public function venta()
    {
        return $this->belongsTo(Venta::class, 'Id_VentaFK', 'Id_Venta');
    }

    public function producto()
    {
        return $this->belongsTo(Producto::class, 'Id_ProductoFK', 'Id_Producto');
    }
}

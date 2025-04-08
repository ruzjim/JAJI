<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Venta extends Model
{
    use HasFactory;

    protected $table = 'venta';
    protected $primaryKey = 'Id_Venta';
    public $timestamps = true;

    protected $fillable = ['Monto_Total', 'Id_PagoFK', 'idCierre','idusuario'];

    public function pago()
    {
        return $this->belongsTo(Pago::class, 'Id_PagoFK', 'Id_Pago' );
    }

    public function puntos()
{
    return $this->belongsToMany(Punto::class, 'venta_puntos', 'Id_VentaFK', 'Id_PuntosFK')
                 ->withPivot('created_at', 'updated_at');
}

protected $casts = [
    'Created_At' => 'datetime',
    'Updated_At' => 'datetime',
];

// En el modelo Venta
public function usuario()
{
    return $this->belongsTo(User::class, 'idusuario');
}

public function cierre()
{
    return $this->belongsTo(Cierre::class, 'idCierre');
}

public function productos()
{
    return $this->hasMany(VentaProducto::class, 'Id_VentaFK');
}

}

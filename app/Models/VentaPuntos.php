<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class VentaPuntos extends Model
{
    use HasFactory;

    protected $table = 'venta_puntos';
    protected $primaryKey = 'id';
    public $timestamps = true;

    protected $fillable = ['Id_PuntosFK', 'Id_VentaFK'];
}

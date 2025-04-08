<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Pago extends Model
{
    use HasFactory;

    protected $table = 'pago';
    protected $primaryKey = 'Id_Pago';
    public $timestamps = true;

    protected $fillable = ['Metodo_Pago', 'Id_ClienteFK'];

    public function ventas()
{
    return $this->hasMany(Venta::class, 'Id_PagoFK');
}
}

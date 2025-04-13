<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Notificacion extends Model
{
    use HasFactory;

    protected $table = 'notificacion';
    protected $primaryKey = 'Id_Notificacion';

    protected $fillable = [
        'Tipo',
        'Estado',
        'Mensaje',
    ];

    public $timestamps = true;
}

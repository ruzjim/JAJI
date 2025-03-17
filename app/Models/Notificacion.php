<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Notificacion extends Model
{
    use HasFactory;

    protected $table = 'notificacion';
    protected $primaryKey = 'Id_Notificacion';

    protected $fillable = [
        'Tipo', 'Estado', 'Mensaje', 'created_at', 'updated_at'
    ];

    public $timestamps = true;
}

<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Comentario extends Model
{
    use HasFactory;

    protected $table = 'comentario';
    protected $primaryKey = 'Id_Comentario';

    protected $fillable = [
        'Comentario',
        'Id_ClienteFK',
        'Estado',
    ];

    public $timestamps = true;

    // Relaciones (si más adelante quieres vincular con Cliente)
    public function cliente()
    {
        return $this->belongsTo(Cliente::class, 'Id_ClienteFK', 'Id_Cliente');
    }
}

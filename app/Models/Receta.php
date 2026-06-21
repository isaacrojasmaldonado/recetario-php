<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Receta extends Model
{
    use HasFactory;

    protected $table = 'recetas';

    protected $fillable = [
        'nombre_recetas',
        'email',
        'id_tiporeceta',
        'dificultad'
    ];

    /**
     * Una receta pertenece a un tipo de receta.
     */
    public function tiporeceta()
    {
        return $this->belongsTo(Tiporeceta::class, 'id_tiporeceta');
    }
}

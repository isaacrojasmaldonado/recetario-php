<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Tiporeceta extends Model
{
    use HasFactory;

    protected $table = 'tiporecetas';

    protected $fillable = [
        'nombre_tiporeceta',
        'color_hex'
    ];

    /**
     * Un tipo de receta puede tener muchas recetas.
     */
    public function recetas()
    {
        return $this->hasMany(Receta::class, 'id_tiporeceta');
    }
}

<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Image extends Model
{
    // Primero habilitamos la asignacion masiva
    protected $fillable = [
        'imageable_id',
        'imageable_type',
        'url',
    ];

    // Luego creamos la relacion prolimorfica en la tabla con estos dos campos
    // Este metodo debe de tener el mismo nombre que colocamos a las columnas especiales
    public function imageable(){
        // Aqui nos retornara una relacion polimorphica
        return $this->morphTo();
    }
}

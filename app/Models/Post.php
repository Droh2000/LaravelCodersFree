<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Post extends Model
{
    /** @use HasFactory<\Database\Factories\PostFactory> */
    use HasFactory;

    // Relacio inversa de uno a muchos
    public function category(){
        // La relacion inversa siempre se define con "belongsTo"
        return $this->belongsTo(Category::class);
    }

    // Relacion Muchos a Muchos con la tabla Tags
    public function tags(){
        return $this->belongsToMany(Tag::class)
                // Para que tambien nos mande los campos extras que no sean los ID, entre comillas pasamos el nombre del campo
                ->withPivot('data')
                // Esto para que se registren los datos en la columna create_at y update_at
                ->withTimestamps();
    }
}

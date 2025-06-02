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
    /*public function tags(){
        return $this->belongsToMany(Tag::class)
                // Para que tambien nos mande los campos extras que no sean los ID, entre comillas pasamos el nombre del campo
                ->withPivot('data')
                // Esto para que se registren los datos en la columna create_at y update_at
                ->withTimestamps();
    }*/

    // Relacion Uno a Uno Polimorfica
    // El nombre es en singular porque solo podemos recuperar una imagen
    public function image(){
        // El primer parametro es el modelo con el cual queremos relacionarlo y el segundo parametro es el nombre de la relacion polimorfica
        // que seria el nombre del metodo que le creamos
        return $this->morphOne(Image::class, 'imageable');
    }

    // Relacion Uno a Muchos Polimorfica
    public function comments(){
        // Pasamos la clase con la cual queremos relacionar este modelo y entre comillas el nombre del metodo de la relacion polimorfica de "Comment"
        return $this->morphMany(Comment::class, 'commentable');
    }

    // Relacion Muchos a muchos polimorficas entre Post y Tags (Se comenta la Relacion muchos a muchos normal porque no puede funcionar con esta)
    public function tags(){
        // Le pasamos el Nombre del modelo con el cual queremos relacionarlo y entre comillas el nombre en singular de los campos
        return $this->morphToMany(Tag::class, 'taggable')
                    ->withTimestamps();// Esto para registrar los campos "create_at" y "update_at"
    }
}

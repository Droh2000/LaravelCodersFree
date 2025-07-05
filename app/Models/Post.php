<?php

namespace App\Models;

use App\Observers\PostObserver;
use Illuminate\Database\Eloquent\Attributes\ObservedBy;
use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Storage;

// En el metodo tenemos que implementarle el Observer
#[ObservedBy(PostObserver::class)]
class Post extends Model
{

    // Para poder usar el Factory
    use HasFactory;

    protected $fillable = [
        'title',
        'slug',
        'image_path',
        'excerpt',
        'content',
        'is_published',
        'published_at',
        'user_id',
        'category_id',
    ];

    // Casteamos los valores que no son de tipo String a su tipo especificiado en la tabla
    protected $cast = [
        'is_published'=>'boolean',
        'published_at'=>'datetime',
    ];

    // Para no estar agregando en las vistas la misma verificacion de que si viene una imagen mostrarla sino no la muestra
    // agregamos aqui esta validacion, para esto vamos a usar los Accesores, con esto podemos agregar mas atributos de los que tenemos
    // Este metodo nos debe de retornar una instancia de la clase Attribute
    protected function image() : Attribute
    {
        return Attribute::make(
            // Esta funcion podria recibir un parametro, eso quiere decir que este acceso lo vamos a usar para modificar algunas de las propiedades
            // que ya tenemos definidas (Esto es para el caso que el metodo se llame igual a una propiedad que ya existe y con esto la funcion toma
            // su valor y lo podemos modificar)
            // Si queremos agregar un valor solo nombramos el metodo de otra forma y dentro agregamos la valdiacion que queremos verificar
            // Usamos This para que el acceso sea sobre el objeto
            get: fn() => $this->image_path ? Storage::url($this->image_path) : 'No Image Implemented',
        );
    }
    // Con esto en las vistas solo llamamos al metodo: $post->image

    public function category(){
        return $this->belongsTo(Category::class);
    }

    public function user(){
        return $this->belongsTo(User::class);
    }

    public function comments(){
        return $this->hasMany(Comment::class);
    }

    public function tags(){
        return $this->belongsToMany(Tag::class);
    }
}

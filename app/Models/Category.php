<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Category extends Model
{
    // Aqui y en los demas modelos Habilitamos la asignacion masiva
    protected $fillable = ['name'];

    // Aqui y en los demas modelos agregamos las relaciones de Eloquent
    public function posts()
    {
        return $this->hasMany(Post::class);
    }
}

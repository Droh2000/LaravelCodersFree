<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Category extends Model
{
    // Para poder ejecutar los factories le agregamos esto al modelo
    use HasFactory;

    // Aqui y en los demas modelos Habilitamos la asignacion masiva
    protected $fillable = ['name'];

    // Aqui y en los demas modelos agregamos las relaciones de Eloquent
    public function posts()
    {
        return $this->hasMany(Post::class);
    }
}

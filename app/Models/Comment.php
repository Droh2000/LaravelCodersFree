<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Comment extends Model
{
    // Habilitamos la asignacion masiva
    protected $fillable = [
        'body',
        'commentable_id',
        'commentable_type'
    ];

    // Agregamos la relacion polimorfica
    public function commentable()
    {
        return $this->morphTo();
    }
}

<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Tag extends Model
{
    /** @use HasFactory<\Database\Factories\TagFactory> */
    use HasFactory;

    // Relacion Muchos a Muchos con la tabla Post
    public function posts(){
        return $this->belongsToMany(Post::class)
                    ->withTimestamps();
    }
}

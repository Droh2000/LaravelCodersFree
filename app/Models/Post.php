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
}

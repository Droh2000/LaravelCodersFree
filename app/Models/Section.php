<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Section extends Model
{
    /** @use HasFactory<\Database\Factories\SectionFactory> */
    use HasFactory;

    // Relacion Uno a Muchos con las lecciones
    public function lessons(){
        return $this->hasMany(Lesson::class);
    }
}

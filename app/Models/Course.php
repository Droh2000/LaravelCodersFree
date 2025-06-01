<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Course extends Model
{
    /** @use HasFactory<\Database\Factories\CourseFactory> */
    use HasFactory;

    // Relacion Uno a Muchos con la tabla Section
    public function sections(){
        return $this->hasMany(Section::class);
    }

    //Relacion uno a muchos a travez de
    public function lessons(){
        // El primer modelo es por cual queremos relacionar directamente esta clase y el segundo modelo es por el
        // que tenemos que pasar antes de llegar al primer del modelo
        return $this->hasManyThrough(Lesson::class, Section::class);
    }
}

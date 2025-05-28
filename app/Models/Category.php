<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Category extends Model
{
    use HasFactory;

    // Habilitar la asignacion masiva
    // Dentro del array le decimos que valores queremos permitir que se guarden por asignacion masiva
    protected $fillable = [
        'name' // El unico valor que almacenara asi, es "name"
        // Asi si un usuario agrega valores extras para enviar, ignorara todos esos y solo se enviaran los que especificamos aqui
    ];

    // Si tenemos muchos campos y para la mayoria vamos a permitir la asignacion masiva y solo unos pocos queremos omitirlos
    // En esta propiedad especificamos los campos que queremos omitir de la asignacion masiva
    // Tenemos que tener comentada el codigo de arriba para que funcione
    protected $guarded = [
        'id',
        'created_at',
        'updated_at'
    ];
}

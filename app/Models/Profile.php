<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Profile extends Model
{
    use HasFactory;

    // Habilitamos la asignacion masiva
    protected $guarded = [
        'id',
        'created_at',
        'updated_at',
    ];
    // Si ejecutamos lo seeders sin habilitar la asignacion masiva, veremos que si nos permitira igualmente
    // Lo que pasa es que Eloquent detecta desde cual entorna estamos ejecutando, en esta caso dentro de las mismas
    // funciones del framework, cosa distinta a algo externo que ya es por manipulacion externa

    // Especificamos la relacion para obtenero los datos a travez de su FK con la tabla que se relaciona (Users)
    public function user(){
        return $this->belongsTo(User::class);
        // De igual manera si no seguimos el nombre de los campos con las convenciones, se lo especicifamos asi
        //      return $this->belongsTo(User::class, 'user_id', 'id');
    }
}

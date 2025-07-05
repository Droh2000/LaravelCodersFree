<?php

namespace App\Observers;

use App\Models\Post;
use Illuminate\Support\Facades\Storage;

// EScuchar diferentes etapas del ciclo de vida del modelo
class PostObserver
{
    // Esta funcion se activara justo cuando se ejecuta el metodo de "update" en el controlador
    // pero antes de que se termine de almacenar en la base de datos
    public function updating(Post $post)
    {
        // Aqui podemos decir como se almacenara la informacion
        // Preguntamos si esta seleccionado para ser publica y ademas no se tiene registro en la fecha de publicacion
        // Cuando estamos ejecutando el metodo "update" le estamos pasando la Data que es donde esta este campo
        if ($post->is_published == 1 && !$post->is_published) {
            $data['published_at'] = now();
        }
    }

    // Podemos escuchar otro eventos
    // Este metodo se va a ejecutar despues de que se almaceno en la base de datos
    public function updated(){

    }

    // Otro metodos
    // Creating -> Es cuando estamos intendo crear un modelo y queremos modificar la forma en la que se crea
    // Created -> Se ejecuta luego de que ya se creo el registro
    // deleting -> Se ejecuta antes de que se elimine
    // deleted -> Se ejecuta despues de que se elimino

    // Antes de que termine de eliminar un Post verifique si tenia una imagen y si la tiene que la elimine
    public function deleting(Post $post){
        if($post->image_path){
            Storage::delete($post->image_path);
        }
    }
}

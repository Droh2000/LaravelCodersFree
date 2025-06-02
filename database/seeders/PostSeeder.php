<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class PostSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Generamos 100 registros aleatorios para la tabla Post
        // Hay que saber que importa el orden en el que estan los factories, como Post depende de Category
        // es necesario que primero se ejecute el de Category
        // Queremos que cada vez que se cree un Post tambien se cree una imagen asociada
        \App\Models\Post::factory(100)->create()->each(function ($post){
            // Para insertar imagenes, recuperamos el post y una vez ahi ingresamos a la relacion polimorfica que tiene el modelo Post
            // de ai podemos llamar el metodo create y ahi le podemos pasar los datos
            $post->image()->create([
                // Con esto nos crea un nuevo registro de imagen pero va a tomar el Id del post para colocarlo en el campo Imageable_id y toma el rota del modelo
                // para colocarlo en el imageable_type, luego le tenemos que pasar los campos que faltan
                'url' => 'url_image_example'
            ]); // Esto nos crea un imagen por cada post
        });
    }
}

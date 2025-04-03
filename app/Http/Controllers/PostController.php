<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class PostController extends Controller
{
    // Aqui metemos la logica de nuestras rutas
    // Creamos un metodo para cada respectiva Ruta
    public function index(){
        // Como las vistas estan dentro de la carpeta posts, luego ponemos punto para que indicar que debajo 
        // de ese nivel hay un archivo y le colocamos el nombre del archivo de la vista

        // Pasarle parametros a la  vista (Le estamos mandando un elementos HTML)
        $label = "<p>Este es un parrafo</p>";

        // Supongamos que en este array tenemos varios articulos
        $post = [
            [
                'title' => 'Art 1',
                'content' => 'Art 1',
                'tags' => ['tag1', 'tag2', 'tag3'],
            ],
            [
                'title' => 'Art 2',
                'content' => 'Art 2',
                'tags' => ['tag4', 'tag5', 'tag6'],
            ],
            [
                'title' => 'Art 3',
                'content' => 'Art 3',
                'tags' => ['tag7', 'tag8', 'tag9'],
            ],

        ];

        // Supongamos que la BD nos retorno un array vacio y queremos controlar en la vista indicando ese suceso
        $posts2 = [];

        // Esto representa el Dia que lo verificaremos en un Switch para mostrar el nombre
        $dia = 5;

        $cant = 10;

        return view('posts.index', compact('label', 'post', 'dia', 'posts2', 'cant'));
    }

    public function create(){
        return view('posts.create');
    }

    public function store(){
        return 'Ruta para crear un post';
    }

    public function show($post){
        // Pasarle el parametro a la vista (Dentro del Array le pasamos las variables)
        return view('posts.show', /*[
            // Primero le especificamos el nombre por el cual la vista identificara ese valor
            "post" => $post
        ]);*/

            // Ahora si queremos que el nombre de la variable se mantenga en la vista nos podemos ahorrar la sintaxis
            // de arriba llamando solo este metodo, este nos crea un Array a partir del valor
            compact('post')
        );
    }

    public function edit($post){
        /* Si tubieramos mas de un valor
            $prueba = "Funciona la prueba";

            return view('posts.edit', compact('edit', 'prueba')); */
        return view('posts.edit', compact('post'));
    }

    public function update($post){
        return "Ruta para procesar el formulario para editar el post: $post";
    }

    public function destroy($post){
        return "Ruta para eliminar ";
    }
}
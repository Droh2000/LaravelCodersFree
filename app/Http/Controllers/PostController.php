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
        return view('posts.index');
    }

    public function create(){
        return view('posts.create');
    }

    public function store(){
        return 'Ruta para crear un post';
    }

    public function show($post){
        return view('posts.show');
    }

    public function edit($post){
        return view('posts.edit');
    }

    public function update($post){
        return "Ruta para procesar el formulario para editar el post: $post";
    }

    public function destroy($post){
        return "Ruta para eliminar ";
    }
}

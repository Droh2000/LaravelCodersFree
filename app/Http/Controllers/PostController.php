<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class PostController extends Controller
{
    // Aqui metemos la logica de nuestras rutas
    // Creamos un metodo para cada respectiva Ruta
    public function index(){
        return "Hola desde la pagina de posts";
    }

    public function create(){
        return 'Ruta para crear posts';
    }

    public function store(){
        return 'Ruta para crear un post';
    }

    public function show($post){
        return "Ruta para mostrar el post con el identificador $post";
    }

    public function edit($post){
        return "Aqui se mostrara el formulario para editar el post: $post";
    }

    public function update($post){
        return "Ruta para procesar el formulario para editar el post: $post";
    }

    public function destroy($post){
        return "Ruta para eliminar ";
    }
}

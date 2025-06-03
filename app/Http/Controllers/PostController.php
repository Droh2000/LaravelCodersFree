<?php

namespace App\Http\Controllers;

use App\Models\Post;
use Illuminate\Http\Request;

// Este controlador es para conectarlo con el formulario que tenemos en Blade
class PostController extends Controller
{
    public function index(){
        // Obtenemos todo el listado de posts
        $posts = Post::paginate();
        return view('postsForm.index', compact('posts'));
    }

    public function create(){
        return view('postsForm.create');
    }

    public function store(){

    }

    public function show(string $post){
        // Aqui queremos mostrar el detalle del post (En la variable "post" obtenemos el Id del post correspondiente)
        // asi que obtenemos el post de la base de datos
        $post = Post::find($post);
        return view('postsForm.show', compact('post'));
    }

    public function edit(string $post){
        return view('postsForm.edit');
    }

    public function update(Request $request, string $post){

    }

    public function destroy(string $post){

    }
}

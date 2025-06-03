<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\Post;
use Illuminate\Http\Request;

// Este controlador es para conectarlo con el formulario que tenemos en Blade
class PostController extends Controller
{
    public function index(){
        // Obtenemos todo el listado de posts (Para que nos salgan los post mas nuevos al inicio de la tabla usamos
        // que nos ordene de manera desendente de acuerdo al campo ID)
        $posts = Post::latest('id')->paginate();
        return view('postsForm.index', compact('posts'));
    }

    public function create(){
        // Recuperamos todas las categorias que teniamos en la base de datos, para tener disponible dentro del formulario de creacion
        // las categorias
        $categories = Category::all();
        return view('postsForm.create', compact('categories'));
    }

    public function store(Request $request){
        /*
            Evitamos que el formulario se mande si tiene campos en blanco
            Esto lo podriamos hacer poniendo "required" en cada los inputs, el problema es que esto se puede editar en el navegador
            asi que la validacion a parte de agregarla al Fronted tambien la hacemos por parte del backend porque aqui no se puede modificar
            Aqui con el "request" obtenemos todos los parametros que han llegado al formulario, aqui vamos a poner los campos como obligatorios
            pero tenemos muchas otras reglas de validacion
        */
        $request->validate([
            'title' => 'required',
            'body' => 'required',
            'category_id' => 'required',
        ]);
        // Cuando el usuario nos mande por el formulario de "create.blade.php" algo, esto sera enviado a la ruta del "action" que es este metodo
        // lo que nos manden lo podemos recuperar con este objeto "request" que se activa cuando se preciona el boton del formulario y serian los campos
        // Procesamos la informacion para almacenarla en la base de datos
        Post::create($request->all());
        // Mandamos al listado de Post para ver que se vea que si se creo (Redireccionamos a una ruta)
        return redirect()->route('post.index');
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

<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Category;
use App\Models\Post;
use Illuminate\Http\Request;

class PostController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        // Recuperar el listado de posts pero los vamos a retornar paginados (Esto por defecto nos retornar un JSON)
        $posts = Post::paginate();
        return view('admin.posts.index', compact('posts'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        // Los posts se relacionan con Categorias
        $categories = Category::all();

        return view('admin.posts.create', compact('categories'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        // Esto es lo que se ejecutando cuando damos en Submit al formulario
        // Agregamos las validaciones
        $data = $request -> validate([
            'title' => 'required|string|max:255',
            'slug' => 'required|string|max:255|unique:posts,slug', // El campo debe ser unico en la tabla Posts en el campo Slug
            'category_id' => 'required|exists:categories,id',
        ]);

        // Agregar la relacion de los datos con el Usuario que tendra relacion con el Post
        // acccediendo a la informacion del usuario autenticado y tomar su ID
        // Al metodo "auth" le especificamos el GUARD con el vamos a trabajar (Aqui especificamos el tipo de autenticacion, en este caso es
        // en base a sessiones pero tambien esta la de Tokens)
        $data['user_id'] = auth('web')->id();

        $post = Post::create($data);

        // Aqui mostramos que nos salga un Alerta de SweetAlert pero para que nos aparesca tenemos que configurar su JS en la vista
        // a donde esta redireccionando que en este caso es en la pagina de Edit
        session()->flash('swal', [
            'icon' => 'success',
            'title' => 'Post Creado!',
            'text' => 'El Post se ha creado correctamente',
        ]);

        // Redireccionamos a la pagina de edit por si el usuario quiere seguir edtando
        return redirect()->route('admin.posts.edit', $post);
    }

    /**
     * Display the specified resource.
     */
    public function show(Post $post)
    {
        return view('admin.posts.show', compact('post'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Post $post)
    {
        return view('admin.posts.edit', compact('post'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Post $post)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Post $post)
    {
        //
    }
}

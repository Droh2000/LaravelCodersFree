<?php

namespace App\Http\Controllers;

use App\Models\Post;
use Illuminate\Http\Request;

class PostController extends Controller
{
    public function show(Post $post)
    {
        // Para mostrar los Post que se relacionan con el post que se accedio, para eso agregamos la parte de etiquetas
        // y la de categorias, en caso que no se tenga etiquetas equivalentes
        $relatedPosts = Post::where('is_published', true)
            // Este filtro es para que no salga en recomendacion el mismo post que se esta leyendo
            ->where('id', '!=', $post->id)
            // Consultamos la relacion entre Posts y Etiquetas
            // Entre comillas le pasamos el nombre de la relacion que queremos consultar 'tags' que esta en Post.php
            // Vamos a hacer que nos traigan aquellos posts que compartan alguna etiqueta con el "$post" por eso usamo "use" para que use la informacion del Post que recibimos
            ->whereHas('tags', function($query) use($post){
                $query->whereIn('tags.id', $post->tags->pluck('id'));
            })
            // Obtenemos cuantas etiquetas relacionadas tiene
            ->withCount([
                'tags' => function($query) use($post){
                    $query->whereIn('tags.id', $post->tags->pluck('id'));
                }
            ])
            // Ordenamos para que los que tengan mas etiquetas en comun son los que van a salir primero
            ->orderBy('tags_count', 'desc')
            ->orderBy('published_at', 'desc')
            ->take(4) // Solo queremos mostrar 4 articulos relacionados
            ->get();

        // Verificamos si la cantidad de post relacionados es menor al numero indicado
        // entonces vamos a recuperar los post que sean similares por categorias
        if($relatedPosts->count() > 4){
            $relatedPosts2 = Post::where('is_published', true)
                ->where('id', '!=', $post->id)
                // Nos aseguramos que los posts sean de la misma categoria
                ->where('category_id', $post->category_id)
                // Los posts que nos traiga no deben de ser parte de los posts que hemos recuperado anteriormente
                ->whereNotIn('id', $relatedPosts->pluck('id'))
                ->orderBy('published_at', 'desc')
                ->take(4 - $relatedPosts->count()) // Le quitamos la cantidad que ya tengamos
                ->get();

            // Fusionamos los dos resultados de los Posts obtenidos
            $relatedPosts = $relatedPosts->merge($relatedPosts2);
        }

        return view('posts.show', compact('post', 'relatedPosts'));
    }
}

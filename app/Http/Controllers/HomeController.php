<?php

namespace App\Http\Controllers;

use App\Models\Post;
use Illuminate\Http\Request;

class HomeController extends Controller
{
    public function index()
    {
        // Traernos el listado de Post pero que sean ordenados de acuerdo al campo "Published_at"
        $post = Post::orderBy('published_at', 'desc')
            ->where('is_published', true) // Traernos solo los posts que se encuentran publicados
            ->paginate(8);

        return view('welcome', compact('posts'));
    }
}

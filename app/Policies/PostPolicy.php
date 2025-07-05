<?php

namespace App\Policies;

use App\Models\Post;
use App\Models\User;

class PostPolicy
{
    public function author (User $user, Post $post)
    {
        // El id del usuario autenticado debe conicidir con el id del usuario del Post
        return $user->id === $post->user_id;
    }
}

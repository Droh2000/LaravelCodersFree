<?php

namespace App\Providers;

use Illuminate\Support\Facades\Gate;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        // Esta es otra forma de proteger las rutas
        Gate::define('admin', function($user){
            // Esta funcion nos debe de retornar un booleano
            // Verificamos el campo de la tabla
            return $user->is_admin;
        });

        // Gate para que el usuario no pueda modificar la URL y acceder a posts no permitidos
        Gate::define('author', function( $user, $post){
            // El id del usuario autenticado debe conicidir con el id del usuario del Post
            return $user->id === $post->user_id;
        });
    }
}

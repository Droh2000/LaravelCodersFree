<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\View;

// Este provider se creo para separar la logica y no tenerla todo en el ServiceProvider principal
// Solo se va a encargar unica en lo referente a las vistas
class ViewServiceProvider extends ServiceProvider
{
    /**
     * Register services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap services.
     */
    public function boot(): void
    {
        // Cuando tenemos el caso en el que queremos pasar el mismo parametro a muchas vistas 
        // Dentro de este metodo definimos el parametro a mandar a todas las vistas
        // Definimos la variable "prueba" seguido del valor (Ya asi este valor esta disponible en todas las vistas)
        View::share('prueba', 'Este es un mensaje de prueba');
    }
}

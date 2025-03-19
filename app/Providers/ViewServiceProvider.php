<?php

namespace App\Providers;

use App\View\Composers\CompanyComposer;
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

        // Para el caso en el que queremos mandarle parametros no a todas las vistas sino solo a unas cuantas
        // en este caso tenemos que trabajar con "ViewComposer"
        // El primer parametro es el nombre de la vista a la cual queremos compartir informacion,seguida de una funcion que recibe un parametro
        // que es un objeto y atravez de ahi podemos definir la informacion que queremos compartir
        // Si requerimos pasarlo a mas vistas ponemos un Array y separamos por comas el resto de vistas a compartir
        //  ['welcome', 'vista2', 'vista3', ...]
        View::composer('welcome', function($view){
            // Dentro del metodo "with" definimos el nombre de la variable y su valor
            $view->with('prueba2','Este es un mensaje de prueba');
        });

        // Ahora lo que almacenara la variable sera lo que nos regresa la clase
        View::composer('posts.index', CompanyComposer::class);
    }
}

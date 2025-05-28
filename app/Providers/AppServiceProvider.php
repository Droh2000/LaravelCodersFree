<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\Route;

// Ya que en la paginacion de Laravel por defecto esta hecha para usar con TailwindCSS pero para el caso
// que no queramos usar ese framework, indicamos aqui que queremos usar otro como Bootstrap
Use Illuminate\Pagination\Paginator;
// Este paquete ademas es para indicar que la paginacion creada por nosotros y no por laravel, se la pagina que use por defecto

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
    // De manera global queremos que siempre que hagamos referencia a un parametro se cumpla
    // una validacion en especifico, por ejemplo que siempre que hagamos referencia al ID
    // siempre se valida que sea un campo numerico
    public function boot(): void
    {
        // Para probar creamos una ruta que reciba el ID, automaticamente se ejecutara esta validacion
        Route::pattern('id', '[0-9]+');

        // Suponiendo que nos pieden que quitemos los nombres en ingles de los metodos de la URI
        // Aqui podemos cambiarles el nombre (Esto solo sirve para cuando creemos rutas de tipo Resource)
        /*Route::resourceVerbs([
            'create' => 'crear',
            'edit' => 'editar',
        ]);

            Esta linea se comento porque nos pasaba que al ingresar a la ruta
                * posts/create -> Se ejecutaba la ruta de "Show" ya que con las lineas de arriba
                    solo existe la ruta "crear" por lo que deberia de ser:
                        * posts/crear
        */

        // Aqui especificamos que queremos usar Bootstrap para la paginacion y no TailwindCSS
        Paginator::useBootstrapFive();

        // Aqui especificamos que mejor use nuestra paginacion creada por nosotros
        Paginator::defaultView('nuestraPaginacion');
    }
}

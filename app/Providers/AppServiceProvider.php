<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\Route;

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

    }
}

<?php

use Illuminate\Foundation\Application;
use Illuminate\Foundation\Configuration\Exceptions;
use Illuminate\Foundation\Configuration\Middleware;
use Illuminate\Support\Facades\Route;

return Application::configure(basePath: dirname(__DIR__))
    ->withRouting(
        web: __DIR__.'/../routes/web.php',
        commands: __DIR__.'/../routes/console.php',
        health: '/up',
        // Aqui es para configurar mas rutas
        then: function(){
            // Queremos agregar rutas de tipo WEB y que solo usarios "auth" puedan acceder
            Route::middleware('web', 'auth')
                // Como todas las rutas que definamos seran solo de Admin, le indicamos aqui que le agrege el prefijo de Admin
                ->prefix('admin')
                // Especificamos que el nombre de todas las rutas empieze asi:
                ->name('admin.')
                // Aqui indicamos el archivo de ruta que queremos incluir
                ->group(base_path('routes/admin.php'));
        }
    )
    ->withMiddleware(function (Middleware $middleware) {
        //
    })
    ->withExceptions(function (Exceptions $exceptions) {
        //
    })->create();

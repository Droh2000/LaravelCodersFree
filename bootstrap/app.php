<?php

use App\Http\Middleware\IsAdmin;
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
            // Aqui habiamos agregado la ruta para administrador pero ahora le agregamos la parte para que use el Midleware que creamos
            // si lo definimos aqui se lo estamos aplicando a todas las rutas definidas en 'routes/admin.php'
            // Queremos agregar rutas de tipo WEB y que solo usarios "auth" puedan acceder
            // Route::middleware('web', 'auth', 'admin') -> Esto se comento porque se agrego el midleware por cada ruta en Routes.php

            // Proteger las rutas usando el Gate, le pasamos el nombre con agregandole al inicio "can:"
            // Route::middleware('web', 'auth', 'can:admin')
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
        // Vamos a crearle un alias al middleware que creamos
        $middleware->alias([
            // Nombre => Middleware
            'admin' => IsAdmin::class,
        ]);
    })
    ->withExceptions(function (Exceptions $exceptions) {
        //
    })->create();

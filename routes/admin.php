<?php

use App\Http\Controllers\Admin\CategoryController;
use App\Http\Controllers\Admin\PostController;
use Illuminate\Support\Facades\Route;

// Aqui vamos a definir las rutas que solo los administradores podran acceder
Route::get('/', function() {
    return view('admin.dashboard');
})
// Si queremos que el middleware no afecte a todas las rutas, por tanto no los definimos en "app.php" sino que aqui mismo especificamos la ruta
// Esto mismo lo tenemos que espcificar todas las demas rutas
->middleware('admin')
->name('dashboard');

// Despues de crear este archivo
// Tenemos que indicarle a laravel que tenemos este nuevo archivo de rutas para que lo tome en cuenta
// agregamos la siguiente linea: "require __DIR__.'/admin.php'" en alguno de los archivos de rutas que ya bienen por defecto
// De otra lo configuramos en "bootstrap/app.php"

// Nos genere todas las rutas de categorias
Route::resource('categories', CategoryController::class);
// Cuando nosotros aplicamos un Middleware para una ruta de tipo Resources por defecto se aplicara para todas las rutas, pero si solo queremos
// proteger ciertas riutas entonces nos vamos al controlador
    //->middleware('admin');

Route::resource('posts', PostController::class);

<?php
use Illuminate\Support\Facades\Route;

// Aqui vamos a definir las rutas que solo los administradores podran acceder
Route::get('/', function() {
    return view('admin.dashboard');
})->name('dashboard');

// Despues de crear este archivo
// Tenemos que indicarle a laravel que tenemos este nuevo archivo de rutas para que lo tome en cuenta
// agregamos la siguiente linea: "require __DIR__.'/admin.php'" en alguno de los archivos de rutas que ya bienen por defecto
// De otra lo configuramos en "bootstrap/app.php"

<?php

use Illuminate\Support\Facades\Route;

// Por defecto cuando queremos acceder a una ruta no definida nos dara 404
Route::get('/', function () {
    return view('welcome');
});

// Podemos definir dos rutas que tengan la misma URI pero de diferente peticion HTTP
// Para no definirlas de forma separadas como arriba, las podemos crear con el metod "match"
// especificandole los metodos de las rutas que queremos que nos cree
Route::match(['get', 'post'], '/contacto', function () {
    return "Hola desde la pagina de contacto usando el metodo GETo POST";
});

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

// Tenemos las rutas que se van creando de manera dinamica que segun lo que cambia en la URL muestra uno 
// u otro contenido (Lo que este entre {} va a depender de lo que el usuario ingrese en la URL)
// El nombre que se le pase entre {} tiene que ser el mismo nombre del argumento de la funcion
Route::get('/cursos/{curso}', function($curso){
    // Lo que el usuario introdusca en {curso} lo podremos mostrar con $curso
    return "Bienvenido al curso: $curso";
});

// Laravel compara los URL de arriba para abajo, por lo que si una remplaza a otra, sera la que este mas arriba la que se muestre
// Asi toma la parte de "information" como si fuera la ruta dinamica (La tenemos que mover mas arriba antes de la dinamica)
Route::get('/cursos/informacion', function () {
    return "Aqui esta la informacion del curso";
});

// Recibir mas de un parametro en ruta dinamica
// Para que uno de los parametros sean opcionales le colocamos el simbolo ? y en la funcion asignarle un valor por defecto
Route::get('/cursos2/{curso}/{category?}', function($curso, $category = null){
    if($category){
        return "Bienvenido al curso: $curso y de la cateogoria $category";
    }else{
        return "Bienvenido al curso: $curso";
    }
});

// Controlar la forma en la que se pasan los parametros para que no vengan con caracteres extraños
// para especificar un formato tenemos las RegEx
Route::get('/cursos3/{curso}/{category?}', function($curso, $category = null){
    return "Bienvenido al curso: $curso y de la cateogoria $category";    

// Si queremos que el parametro "curso" solo pueda recibir valores alfabericos
// Al metodo WHERE le pasamos el nombre del parametro despues la expreccion regular
// Ahora como aqui recibimos dos argumentos en la URL, le pasamos a la funcion un arreglo 
})/*->where(
    // 'curso', '[A-Za-z]+' -> Esto es si tenemos un solo argumento
    [
        'curso' => '[A-Za-z]+',
        'category' => '[A-Za-z]+'
    ]);
    */

// Si bien podemos escribir nuestras RegEx en Laravel tenemos metodos que ya tienen las exprecciones
// Con este los parametros solo se aceptan con valores alfabeticos
//      ->whereAlpha('curso')
// Con este solo acepta en el argumento los valores que esten en la lista
->whereIn('curso', ['php','laravel','vue'])
->whereAlphaNumeric('category');

Route::get('/cursos4/{id}', function ($id) {
    return "Bienvenido al curso con el Id: $id";
});
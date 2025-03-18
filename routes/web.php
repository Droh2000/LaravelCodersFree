<?php

use Illuminate\Support\Facades\Route;

// Por defecto cuando queremos acceder a una ruta no definida nos dara 404
Route::get('/', function () {
    // return view('welcome');
    
    // Esta es la razon por la que se le dan nombre a las rutas
    // Le pasamos el nombre de una de las rutas
    //      return route('cursos.informacion'); // Esto nos da URI

    // Ahora supongamos que nos piden cambiar la URL y pase de /curso/ a /materias/
    // Como en la redireccion estamos haciendo referencia al nombre con "route()" y no a la URI directamente
    // no tendremos problemas y no tendremos errores en todo el sistema
    // Entonces no hacer referencia directamente a la URI sino al nombre de las rutas

    // Para las rutas que esperan un parametro
    // Al metodo "route" le pasamos un segundo parametro que seria el argumento que espera
    // Si la ruta espera mas de un parametro colocamos esto dentro de un array
    //return route('cursos.show', ["id" => 4]);

    return "Hola desde la pagina de inicio";
});

// Creacion de rutas para hacer un CRUD (Vamos a usar el ejemplo de articulos)

// Mostrar el listado de registros
Route::get('/posts', function(){
    return 'Ruta de listado de Posts';
});

// Mostrar un formulario para crear un registro
Route::get('/posts/create/', function($id) {
    return 'Ruta para crear posts';
});

// Guardar un registro procesando la informacion que mandemos del formulario
Route::post('/posts', function ($id) {
    return 'Ruta para crear un post';
});

// Mostrar los datos de un registro
// Hay que tener cuidado con el orden en el que creamos el Post ya que la de "/posts/create" cumple la misma estrcutura de esta
// por eso se crea esta ruta despues antes que la de "create"
Route::get('posts/{post}', function ($post) {
    return "Ruta para mostrar el post con el identificador $post";
});

// Mostrar un formulario de Edicion
// Este formulario ya debe estar lleno con los datos que queremos editar por eso le mandaremos el identificador en la URL
Route::get('/posts/{post}/edit', function($post){
    return "Aqui se mostrara el formulario para editar el post: $post";
});

// (Actualizar) Procesar los datos que se manden desde el formulario de edicion
Route::put('/posts/{post}', function ($post) {
    return "Ruta para procesar el formulario para editar el post: $post";
});

// Eliminar un registro
Route::delete('/posts/{post}', function ($post) {
    return "Ruta para eliminar ";
});
// Gracias al uso de diferentes verbos HTTP podemos seguir usando la misma ruta

/*
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
})->name('cursos.informacion');

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
})->where(
    // 'curso', '[A-Za-z]+' -> Esto es si tenemos un solo argumento
    [
        'curso' => '[A-Za-z]+',
        'category' => '[A-Za-z]+'
    ]);
    

// Si bien podemos escribir nuestras RegEx en Laravel tenemos metodos que ya tienen las exprecciones
// Con este los parametros solo se aceptan con valores alfabeticos
//      ->whereAlpha('curso')
// Con este solo acepta en el argumento los valores que esten en la lista
->whereIn('curso', ['php','laravel','vue'])
->whereAlphaNumeric('category');

Route::get('/cursos4/{id}', function ($id) {
    return "Bienvenido al curso con el Id: $id";
})->name('cursos.show');
*/
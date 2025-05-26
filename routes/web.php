<?php

use App\Http\Controllers\HomeController;
use App\Http\Controllers\PostController;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\DB; // Importamos para poder usar el QueryBuilder

// Por defecto cuando queremos acceder a una ruta no definida nos dara 404
// Creamos un control adicional que se encarga de administrar esta ruta (No es recomendable crear un controlador para todo y que maneje varios recursos)
// Cuando usamos metodos invok al especificar la ruta no requerimos especificarle el metodo sino que solo le pasamos el controlador
Route::get('/', HomeController::class);
//function () {
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

    //return "Hola desde la pagina de inicio";
//});

// Creacion de rutas para hacer un CRUD (Vamos a usar el ejemplo de articulos)

// Reducir las lineas de codigo a una sola para la creacion de rutas (Con el metodo RESOURCE que nos crea las rutas requeridas para CRUD)
// El primer parametro es la URI con la que van a empezar las demas rutas, el segundo parametro es el nombre del controlador
// Esto ya nos crea las rutas y asigna el metodo correspondiente a cada ruta y con nombre (Segun el nombre de la URI pasada)
//Route::resource('posts', PostController::class);// Verificamos con: php artisan r:l
    // Si no queremos todas las rutas que nos crea por defecto el metodo ya que no las requerimos todas
    // Le pasamos entre el array el nombre de los metodos
    //      ->except(['create', 'edit']);
    // Con esto indicamos que solo queremos crear algunas rutas en especifico
    //      ->only(['index', 'create']);
    // Para modificar la URI pero que se sigan manteniendo los nombres de las rutas
    //      ->names('post'); // Aqui le indicamos el nombre que ya tenian las rutas anteriormente suponiendo que cambiamos la URI
    // Para que el del parametro tambien tenga el nombre que le especifiquemos aqui
    // Aqui hacemos referencia al nombre de la URI => Nombre del Parametro
    //      ->parameters(['articulos' => 'post']);

// Si estamos construyendo una API y queremos generar asi las rutas usamos este metodo
//      Route::apiResource('posts', PostController::class);


//      Mostrar el listado de registros
// Cuando queramos definir rutas para distintas areas y requerimos agruparlas (Clasificarlas) para esto tenemos otra
// forma de organizar nuestra rutas (Grupo de Rutas)
// Por ejemplo estas rutas tienen cosas en comun (Misma URL, Mismo Controlador, Nombres Similares)
// Definicion de un Grupo de rutas en el que comparten el mismo controlador
// Luego como todas empiezan con "/posts" esto lo hacemos con el metodo "prefix" para indicar que todas las rutas empezar con ese prefijo
// Lo mismo para los nombre para indicar que con "name()" todas vana a empezar con el nombre "post."
Route::prefix('posts')->name('posts.')->controller(PostController::class)->group(function(){
    // Todas las rutas que definamos dentro de esta funcion van a estar compartiendo el mismo controlador
    // asi que al definir la ruta solo le definimos el nombre del metodo

    // En lugar de la funcion le pasamos el controlador y el metodo en un Array
    Route::get('/', 'index')
    // Aprovechamos para darle nombre a las rutas, para esto seguimmos la convencion de Laravel
    // que seria la URI.NOMBRE_METODO
    ->name('index');

    // Mostrar un formulario para crear un registro
    Route::get('/create', 'create')->name('create');

    // Guardar un registro procesando la informacion que mandemos del formulario
    Route::post('/', 'store')->name('store');

    // Mostrar los datos de un registro
    // Hay que tener cuidado con el orden en el que creamos el Post ya que la de "/posts/create" cumple la misma estrcutura de esta
    // por eso se crea esta ruta despues antes que la de "create"
    Route::get('/{post}', 'show')->name('show');

    // Mostrar un formulario de Edicion
    // Este formulario ya debe estar lleno con los datos que queremos editar por eso le mandaremos el identificador en la URL
    Route::get('/{post}/edit', 'edit')->name('edit');

    // (Actualizar) Procesar los datos que se manden desde el formulario de edicion
    Route::put('/{post}', 'update')->name('update');

    // Eliminar un registro
    Route::delete('/{post}', 'destroy')->name('destroy');
    // Gracias al uso de diferentes verbos HTTP podemos seguir usando la misma ruta
});

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

Route::get('/prueba', function(){
    // Recuperar valores que tenemos en la base de datos, con el metodo "table" especificamos a que tabla queremos hacer la consulta
    $categories = DB::table('categories')
        // ->where('id', 2)// Filtro para que nos regrese solo ciertos datos (id = 2)
        -> where('id','>=',2)    // Agregar Filtro con una condicion
        ->get(); // Recuperamos todos los registros de la tabla
        // ->first();// Este es para que nos regrese el primer elemento del array, asi solo obtenemos el JSON y no el array

    // Otra forma que podemos hacer para filtrar registros por el ID
    // Con el metodo "find()" buscamos por el ID de acuerdo al campo que le pasemos (Nos trae el registro cuyo id sea 4)
    $category = DB::table('categories')->find(4);

    // Supongamos que requerimos un array pero que solo nos incluya ciertos campos que especifiquemos y no todos los datos
    $categories = DB::table('categories')
        // Tambien podemos aplicar filtros
        ->where('id', '>', 1)
        ->pluck('name', 'id'); // Aqui especificamos los campos que requerimos
        // Si queremos que las llaven tomen otro valor de la tabla, esepcificamos un segundo campo en este caso el ID

    // Veremos los datos en formato de Array con un JSON
    // return $categories[0]->name; // Acceder a la propiedad "name" del elemento 0
    // return $category->name; // Esto es si usamos "first()"
    //      return $categories;


    // Si tenemos que manipular muchos datos, no podremos almacenar los datos en una variable, para eso tenemos que trabajar con los datos truncados
    // Recuperar datos de usuario (Si almacenamos en una variable, nos puede decir que no tenemos memoria suficiente)
    $users = DB::table('users')
            ->get();

    //  return $users;

    // Datos Truncados: No nos va a traer todos los datos de la BD al mismo tiempo, sino que nos lo va a ir trayendo por trozos
    DB::table('users')
            // Para poder usar el metodo de abajo requerimos usar primero llamar este, indicando como queremos que se ordenen los registros
            // Por defecto los ordena de manera ascendente (En este caso por el campo ID) si queremos desendente lo especificamos
            ->orderBy('id', 'desc')
            // Le pasamos el tamano del grupo segun de lo que queremos que nos traiga, despues una funcion que recibe los grupos en array
            ->chunk(100, function($users){
                // Asi hace una consulta, nos trae los primeros 100 registros y estos los podemos procesar aqui
                // Cuando termine de procesarlos vuelve a hacer una consulta a la BD hasta que termine
                foreach($users as $user){
                    echo $user->name . '<br>';
                }
            });
            // Si estamos truncando los datos pero nuestro objetivo es ir actualizando los datos que vamos recuperando
            // Para esto en lugar de usar el metodo "chunk" usamos "chunkById", se emplea igual que el metodo de arrriba

});

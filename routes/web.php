<?php

use App\Http\Controllers\HomeController;
use App\Http\Controllers\PostController;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\DB; // Importamos para poder usar el QueryBuilder
use App\Models\User;
use App\Models\Category;

use function Laravel\Prompts\table;

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

    // Esta es otra forma de trabajar con datos Truncados, este metodo "lazy" su diferencia es que a diferencia del metodo "chunk"
    // es que en ese se va agrupando en el arreglo que recibe la funcion, a diferencia de "lazy" nos retorna una coleccion pudiendo
    // acceder a los datos de forma mas practica
    DB::table('users')
            ->orderBy('id')
            // Con "each" vamos recorriendo la coleccion y dentro en la funcion podemos recuperar los datos
            ->lazy()->each(function($user){
                // Aqui podemos acceder a los registros individuales (No agrupados como antes)
                echo $user->name . '<br>';
            });
            // Si queremos ir actualizando los datos que vamos recuperando podemos usar el metodo "lazyById"

    // Otros metodos que podemos usar
    // Si nos interesa saber cuantos registros hay en una tabla
    DB::table('users')->count();
    // Obtener el maximo o menor numero de un determinado campo
    DB::table('users')->max('id');
    DB::table('users')->min('id');
    // Obtener el promedio de los valores del campo
    DB::table('users')->avg('id');
    // Consultar si existe un registro en un campo
    if(DB::table('users')->where('id', 5)->exists()){
        echo 'El usuario existe';
    }
    // Verificar si el usuario no existe
    if(DB::table('users')->where('id', 5)->doesntExist()){
        echo 'El usuario No existe';
    }

    DB::table('users')
        // Clausula de seleccion
        // Para cuando no queremos que se nos de todos los campos y solo tomar lo que nos interesa
        // Asi especificamos los campos exactos que queremos que nos traiga
        // si queremos cambiar el nombre de un campo en los datos obtenidos, ponemos 'as' seguido del nombre
        ->select('id', 'name as signature', 'email')
        ->get();

    // Si requerimos de alguna consulta que no podemos lograr con los metodos que nos proporciona Laravel, entonces
    // tambien podemos usar esta forma en la que metemos nuestras propias sentencias SQL
    // Supongamos que queremos crear una sentencia que nos permita crear un campo personalizado donde su contenido sera
    // la fucion de los resultados obtenidos
    DB::table('users')
        // Dentro del DB::raw metemos la sentencia SQL que se va a generar con estos metodos
        ->select('id', 'name as signature', 'email')//, DB::raw('CONCAT(name, "", email) as full_name'))
        // Otra forma de hacerlo es meter aqui directamente la sentencia
        ->selectRaw('CONCAT(name, "", email) as full_name')
        // Supongamos que ahora queremos hacer un filtro mas especifico y no nos sirve el metodo "where()"
        // Dentro de este metodo colocamos toda la sentencia del filtro (La podemos hacer tan compleja como queramos)
        ->whereRaw('id >= 2 AND id <= 5')
        // Este es en el caso que queramos agregar una condicion OR en el filtro Where
        ->orWhereRaw('id <= 5')
        // Agregar la Clausula "Having"
        //  ->havingRaw()
        // Para saber como se van a ordenar los datos
        // ->orderByRaw()
        // ->groupByRaw()
        ->get();

    // Obtenemos todos los registros de los Posts relacionados con su Usuario por el ID
    DB::table('posts')
        // Primero le pasamos la tabla con la que queremos hacer la union, el segundo parametro es la forma en la que vamos a comparar ambas tablas
        // (En este caso del campo user_id de la tabla "Posts" con la tabla "users" de su ID)
        ->join('users', 'posts.user_id', '=', 'users.id')
        // Obtener las categorias relacionadas
        ->join('categories', 'posts.category_id', '=', 'categories.id')
        // Asi es como indicamos que queremos seleccionar todos los campos de la tabla "posts" pero solo queremos el campo "name" de la tabla Users
        ->select('posts.*', 'users.name as user_name', 'categories.name as category_name')
        ->get();

    DB::table('users')
        // Condicional con Where, pasamos nombre del campo y el valor con el cual queremos buscarlo
        // El metodo Where tambien podemos usar cualquier operador que sea compatible con un Sistema gestor de BD
        /*->where('id', '>=', 5)
        ->where('id', '<=', 5)
        ->where('id', '<>', 5)
        ->where('name', 'like', '%di%')*/
        // Esta es una forma de pasarle varias condicionales
        ->where([
            ['id', '>=', '5'],
            ['id', '<=', '10']
        ])
        // Queremos que nos traiga todos los registros con la condicional OR
        // En este caso queremos traer diferentes tipos de correos
        /*->where('email', 'like', '%@example.org%')
        ->orWhere('email', 'like', '%@example.com%')*/
        // Para decir que nos excluya todos los correos que terminen en "example.org" (Asi excluimos unos determinados numeros de elementos)
        ->whereNot('email', 'like', '%@example.com%')
        ->get();

    // Otras clausulas Where
    DB::table('users')
        // Para obtener un rango de filtrados, le pasamos el campo y en el array entre cual y cual valor
        ->whereBetween('id', [5, 10])
        // Este nos traer todos los registros cuyos valores no estan este rango
        ->whereNotBetween('id', [5, 10])
        // Para que nos recupere registros especificos pasandole un calumna y los valores exactos que queremos que nos de
        // si le pasamos un dato que no exista, lo ignorara
        ->whereIn('id', [1, 2, 3])
        // Nos da todos los registros que no esten especificados aqui
        ->whereNotIn('id', [4, 5, 6])
        // Obtener todos los registros que tienen nulo en alguna parte (En esta columna)
        ->whereNull('last_name')
        // Nos de todos los valores que no son nulos
        ->whereNotNull('name')
        // Para la comparacion de fechas, aqui le pasamos el campo fecha y la fecha en formato: Anio-Mes-Dia
        ->whereDate('create_at', '2023-04-01')
        // Para que nos traiga los registros superiores a la fecha indicada
        ->whereDate('create_at','>=' ,'2023-04-01')
        // Recuperar todos los registros que pertenencen a un determinado mes (Aqui como valor solo le pasamos el mes)
        ->whereMonth('create_at', '08')
        // Aplicar el filtro por Dia (Todos los registros que tengan ese dia)
        ->whereDay('create_at', '4')
        // Aplicar filtro por Año
        ->whereYear('create_at', '2025')
        // Aplicar filtro por Hora (A este le podemos agregar modificadores como mayor, igual, menor)
        ->whereTime('create_at', '21:04:41')
        // si queremos comparar que dos columnas tengan el mismo valor, en este caso "create_at" y "update_at" tienen el mismo valor
        // y van cambiando como se van insertando datos, asi podemos verificar cuales son los registros que no se ahn actualizado
        ->whereColumn('create_at', 'update_at')
        // Si queremos los valores que sean mayores a 'update_At'
        ->whereColumn('create_at','>','update_at')

        ->get();

    // Agrupacion Logica
    // Queremos traer todos aquellos registros donde el ID sea mayor o igual a 10 y los correos terminan en 'example.org'
    // o que los correos sean de "example.net"
    DB::table('users')
        /*->where('id', '>=', 10)
        ->where('email', 'like', '%@example.org')
        ->where('email', 'like', '%@example.net')*/
        // Con las lineas de arriba veremos que nos ignora el primer WHERE, esto pasa porque agregamos un OrWhere entonces
        // aunque no este cumpliendo los primeras filtros agregados si cumple el del Or y por eso nos trae ID menores a 10
        // Entonces para que sea primero el Where y de ahi pase a los otros dos, para eso tenemos la agrupacion logica
        ->where('id', '>=', 10)
        // Para agrupar varios where
        ->where(function($query){
            // Debemos de recuperar la consulta que hemos ejecutado anteriormente (Esto lo tenemos en el argumento 'query')
            // Usando esa variable ejecutamos las demas consultas
            $query->where('email', 'like', '%@example.org')
            ->where('email', 'like', '%@example.net');
        })
        ->get();

    // Ordenar Registros
    DB::table('users')
        // Indicamos por cual campo queremos ordenar, despues especificamos el orden (Ascendente o Decendente), por defecto es ascendente
        ->orderBy('name', 'desc')
        // Este metodo nos ordena de manera descendente de acuerdo al campo
        ->latest('name')
        // Este lo ordena por defecto de manera acendente
        ->oldtest('id')
        // Generar ordenes de manera aleatoria, esto nos sirve por si queremos recuperar un registro al azar
        ->inRandomOrder() // este metodo nos ordena de manera aleatoria
        ->first()
        ->get();

    // Si ya hicimos la consulta y ya especificamos un tipo de orden, pero despues queremos elimnar ese orden, por ejemplo ya utilizamos el orden
    // y despues queremos usar la consulta pero sin el orden implementado
    $users = DB::table('users')
        ->inRandomOrder(); // Solo generamos la consulta no ejectuamos el "get()"
    // Eliminamos ese orden (Aqui si se ejecuta el GET)
    $users->reorder()->get();

    // Agrupar Registros
    // Queremos agruparlos para saber cuantos Posts a escrito cierto usuario por su ID
    DB::table('posts')
        // Cuando agrupemos solo debemos tener seleccionado aquellos campos que hemos especificados en "groupBy"
        ->select(
            'user_id', // Lo importante es que solo este Seleccionado el campo por el que agrupamos
            // Para agregar mas informacion y que no solo nos muestre el campo dentro del GroupBY
            DB::raw('count(*) as total') // Contamos cuantos registros tiene el usuario
            // De aqui podemos agregar mas funciones de agregacion
        )
        ->groupBy('user_id')
        // Queremos filtrar y que nos de los registros donde su total sea mayor a dos
        // No podemos usar el Where filtrando por la columna total porque este solo accede a los campos de la tabla, no los puestos por nosotros
        // Cuando creamos un campo y le queremos aplicar un filtro
        ->having('total', '>', 2)
        ->get();

    // Limitar los registros que queremos que nos traiga
    DB::table('users')
        // Podemos especificar que ignore ciertos registros (Para que sean consecutivos)
        // Solo podemos usar este metodo si especificamos el metodo TAKE
        ->skip(3)
        // Queremos obtener los 10 primeros registros
        ->take(10)
        // Estos metodos son lo mismo que el metodo Take
        /*->limit(10)
        ->offset(10)*/
        ->get();

    // Filtros en caso de que se cumpla alguna condicion
    // En PHP cualquier valor que no sea NULL, 0, Cadena Vacia se considera como True
    $prueba = false;

    DB::table('users')
        // Solo queremos aplicar este filtro si el valor de "prueba" es Verdadero
        //->where('id', '>', 10)
        // En este metodo le pasamos el valor que queremos evaluar, la funcion recibe como parametro la consulta
        // en la misma funcion podriamos recibir el valor evaluado
        ->when($prueba, function($query, $prueba){
            // Aplicamos el filtro solo si es True
            $query->where('id', '>=', 10);
            // Aqui nos trae los valores que no sean null
            $query->where('id', '>=', $prueba);
        })
        ->get();

    // Insertar Registros en la Base de datos
    DB::table('users')
        // Dentro del arreglo le pasamos los datos a insertar
        /*->insert([
            'name' => 'Victor Lopez',
            'email' => 'vitor@example.com',
            'password' => bcrypt('123456')
        ]);*/

        // Si queremos agregar mas de un registro
        ->insert(
            [
                'name' => 'Victor Lopez',
                'email' => 'vitor@example.com',
                'password' => bcrypt('123456')
            ],
            [
                'name' => 'Iris Black',
                'email' => 'iras@example.com',
                'password' => bcrypt('123456')
            ]
        );

        // Tenemos este metodo para insertar los registros especificados pero si alguno de los registros falla
        // entonces ignora ese registro y continua normalmente con los demas registros
        //  ->insertOrIgnore([])

        // El metodo "upsert()" lo usaremos cuando queremos insertar nuevos registros pero en el caso que ese registro ya exista en la tabla
        // no queremos que lo inserte sino que lo actualice
        DB::table('users')
            ->upsert(
                [
                    // Sabemos que ya existe este registro
                    'name' => 'Victor',
                    'last_name' => 'Ramirez',
                    'email' => 'vitor@example.com',
                    'password' => bcrypt('123456')
                ],
                [
                    // En el segundo Array le indicamos cual es el campo que queremos identificar a cada uno de los registros
                    'email' // En este caso sabemos que el Email es un campo unico
                ],
                [
                    // Aqui especificamos los campos que queremos actualizar
                    'name',
                    'last_name'
                ]
            );

        return 'Usuario creado o actualizado correctamente';

        // Actualizar un Registro
        DB::table('user')
            ->where('id', 1508) // Primero buscamos el registro
            /*->update([
                // Campos que queremos actualizar
                'name' => 'Jose',
                'last_name' => 'Rodriguez',
            ]);*/

            // Con este otro metodo podemos actualizar el registro pero si no existe entonces lo inserta (Para insertart combina los datos de ambos array)
            ->updateOrInsert(
                [
                    // El filtro lo vamos a hacer de cuardo al campo email
                    'email' => 'vitor@example.com'
                ],
                [
                    // Aqui indicamos como queremos actualizar
                    'name' => 'Victoria',
                    'last_name' => 'Ramirez'
                ]
            );

        // Incrementar o Decrementar
        // Si queremos incrementar el valor de uno en uno
        DB::table('users')
            // Primero indicamos sobre cual registro queremos afectar esto
            ->where('id', 1)
            ->increment('ranting', 1);
            // Si queremos disminuir el valor
            // ->decrement('ranting', 1)

        // Eliminar Registros
        DB::table('users')
            ->where('id', 1)
            ->delete();

        // Paginacion
        // Aqui vamos a paginar los registros por ejemplo solo recuperar cierta cantidad de registros y solo mostrar cierta cantidad
        // en una determinada vista
        // En lugar de usar el metodo "get()" usamos "paginate()"
        $user = DB::table('users')
            // Indicamos de cuantos en cuantos registros queremos que se paginen
            // Si no le especificamos un numero por defecto tomara el valor de 15
            ->paginate(15);
            // Al usar este metodo veremos que nos lo retorna en un JSON indicandonos la pagina (1 a N), y ademas tenemos el campo "data"
            // que es un array que engloba todos los registros entre llaves, ademas tenemos otros campos
            // "current_page", "links" (estos son los cuadros de abajo donde nos movemos por flechas hacia atras o hacia adelante)
            // ademas de otros campos para lograr hacer la paginacion del lado del Fronted
        return view('prueba', compact($user)); // Regresamos el JSON a la vista

        // Supongamos que hemos recuperado un listado de usuarios y lo hemos recuperado paginado, ademas tenemos un listado de articulos y tambien lo tenemos paginado
        // En ese caso tenemos dos paginaciones, cuando eso pasa teemos el incoveniente porque ambos usan la URL para ver lo que llega de la paginacion
        // Ya que la URL es: Dominio.test/URL?page=Numero
        // para ese caso:
        $user = DB::table('users')
            // El primer parametro es la cantidad de registros que queremos y el segundo es la cantidad de columnas que queremos que nos retorne dentro de la paginacion
            // (Solo los elementos de informacion que nos interesa), si queremos que nos retorne todo solo colocamos: "['*']"
            // Si queremos que cuando hagamos click sobre uno de los botones de la paginacion en la URL no viaje el valor de Page ya que tenemos dos paginaciones
            // sino que en este caso nos gustaria que viaje el valor de "pageUsers" (Esto lo especificamos como tercer parametro)
            // asi podemos determinar en cual paginacion nos encontramos
            ->paginate(15, ['*'], 'pageUsers');
        return view('prueba', compact($user));

        // Para tener una paginacion Simple, con este solo veremos el boton de Previos/Next
        $user = DB::table('users')
            ->simplePaginate(15);
        return view('prueba', compact($user));

});

Route::get('eloquent', function(){
    // Los Models nos van a mapear una tabla (Cada modelo nos va a representar una tabla), si queremos la tabla Users llamamos el modelo Users
    // Con eloquent tenemos acceso a todos lo metodos que teniamos en QueryBuilder pero ademas tendremos otros metodos
    // Queremos recuperar el listado de todos los usuarios (llamamos al modelo y de ahi con :: llamamos al metodo)
    $users = User::get();
    /*
        ¿Como sabe Eloquent a cual tabla de la BD se tiene que conectar?
            Lo que pasa es que con eloquent se siguen una serie de convenciones es que el modelo se debe de llamar igual que la tabla pero en Singular, llamandose la tabla en Plural
            Tambien como consideracion es que el nombre de las tablas y el nombre de los modelos debe de estar escritos en ingles
            si no queremos escribirlos en ingles podemos espceificarle en el modelo a que tabla se tiene que conectar
    */

    // Ordenar los datos obtenidos de manera descendente
    User::orderBy('id', 'desc')
        ->get();

    // Esto representaria un registro de la tabla
    $user = new User();
    // Cada uno de los campos de la tabla podemos acceder como propiedad
    $user->name = 'Victoria Nones';
    $user->email = 'vicotry@example.com';
    $user->password = bcrypt('12345684');
    // return $user;
    // Al ver el resultado veremos que nos retorna un objeto con las propieades pero veremos que el campo de password no sale, esto es porque en el Modelo Users configuramos
    // para que nos oculte el campo en su propiedad "protected $hiddend"

    // Despues de definirle las propieades le decimos que nos almacene los datos en la BD
    $user->save();
    // return $user;
    // Despues de hacer esto veremos otros campos que no veiamos antes que eran create_at, update_At, Id

    // Normalmente cuando queremos insrtar datos, esta informacion va a venir de un formulario, la informacion que sea ingresada es la que tenemos que recuperar desde
    // el backend y almacenarla en la base de datos
    // Supongamos que lo que hemos recuperado de un formulario, lo tenemos en un array donde tenemos sus respectivos valores
    $data = [
        'name' => 'Programacion'
    ];
    // Usando el array de arriba para almacenar un nuevo dato de cateogoria
    $category = new Category();
    $category->name = $data['name'];
    $category->save();

    // Si tenemos muchos campos que debemos de insertar, para no esta uno por uno, como arriba, eloquent nos proporciona
    // la asinacion masiva, en este caso solo llamamos el modelo y de ahi el metodo, al cual le pasamos un array
    // con las propiedades que queremos cambiar, con esto aprovechamos directamente los valores que han llegado del fomulario
    // Para que la asignacion masiva funcione tiene que estar activada en el modelo porque a diferencia donde estamos agregando los valores
    // uno por uno nosotros teniamos el control total de como queremos que se almacene los datos, cosa que no tenemos cuando la informacion llega
    // desde un formulario porque los usuarios pueden crear campos y desde esos campos mandar informacion que estaria oculta (Como un campo Active=0 o 1)
    // y al guardar nos mandara todos los datos, incluyendo el que agrego el usuario para almacenar los registros, no tenemos el control de cual informacion
    // especifica debe llevar el formulario para poder insertarla
    // Dentro del modelo especificamos que campos son permitidos de almacenar por asignacion masiva (Si se le manda alguno campo que no esta permitido, lo que pasa es que ignora ese campo)
    $category = Category::create($data);
    return $category;

});

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Prueba Paginacion</title>
    <!--<script src="https://cdn.jsdelivr.net/npm/@tailwindcss/browser@4"></script>-->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">
</head>
<body>
    <h1>Usuarios</h1>

    <ul>
        <!-- Recorremos los datos obtenidos, esta accediendo a los datos dentro del array "data"
            y nos los trae deacuerdo a la cantidad por paginacion que indicamos
        -->
        @foreach ($users as $user)
            <li>
                {{ $user->name }}
            </li>
        @endforeach
    </ul>


    <!-- Aqui le agregamos la paginacion, esto ya nos genera el boton para avanzar y regresar y todo el funcionamiento
        Esta paginacion por defecto esta hecha para usar los estilos de TailwindCSS por eso vemos todo feo
        Para verlo mejor vamos a incluir tailwind en el proyecto

    {{/* $users->links() */}}
    -->

    <!--
        Para Personalizar los botones y como se mira la paginacion, ya al mirar el JSNO que nos regresa el metodo veremos
        que nos regresa bastantes propiedades para crear nuestra propia paginacion

        En este caso podriamos llamar una vista diseñada por nosotros mismos donde tendriamos creada esa paginacion
        esto lo hacemos llamando al mismo metodo pero indicandole donde se encuentra esa pagina
        Si configuramos esta vista como "Paginacion por Defecto" en el archivo "AppServiceProvider"
        ya no tendremos que indicarle entre comillas la vista al metodo
    -->
    {{ $users->links('nuestraPaginacion') }}

    <!--
        Si queremos seguir usando la paginacion de laravel pero queremos personalizarla
        Para lograr esto tenemos que tener acceso a las vistas:
            - php artisan vendor:publish --tag=laravel-pagination
        Estas vistas nos salen en el directorio:
            views/vendor/pagination -> Aqui dentro tenemos los archivos que utiliza la paginacion de laravel
        de todos los archivos que hay el que nos interesa es: "default.blade.php"
    -->
</body>
</html>

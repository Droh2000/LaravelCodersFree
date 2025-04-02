<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Cursos de Pago</title>
</head>
<body>
    <h1>Aqui se mostrara el listado de Posts {{ $prueba2 }}</h1>
    {{-- Como es codigo HTML lo que le estamos mandando--}}
    {!! $label !!}

    <!-- Directivas -->
    @if (true)
        <p> Mensaje por ser Verdad </p>
    @else    
        <p> Mensaje por ser False </p>
    @endif

    <!-- Esta espera que el valor que le pasemos sea Falso, si es True no entra -->
    @unless (false)
        <p>Se cumplo que sea falso</p>
    @endunless

    <!-- Con esta verificamos si la variable que le pasemos se encuentra definida -->
    @isset($variable)
        <p>La variable existe y tiene un valor asinado</p>
    @else
        <p>La variable no existe</p>    
    @endisset

    <!-- esta directiva entra si la variable que le pasemos, no existe o tiene almacenado un valor nulo -->
    @empty($variable)
        <p>La variable no existe o no tiene valor asignado</p>
    @endempty


    {{-- Interactuamos con el Array que le pasamos desde JS --}}
    <script>
        // Primero tenemos que convertir los datos de PHP a un formato que entienda JS
        // Esto nos crea una cadena en formato JSON y para asignarle el valor le ponemos los !!
        //      const posts = {!! json_encode($post) !!};

        // Otra formas mas facil es usar la directiva de Blade
        const posts = @json($post);

        console.log(posts);
    </script>
</body>
</html>
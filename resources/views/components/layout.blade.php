<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Ejemplo Formulario</title>
</head>
<body>
    <nav>
        <ul>
            <li>
                <a href="/">Home</a>
            </li>
            <li>
                <!-- Esta lista nos mostrara el listado de Posts -->
                <a href="{{ route('posts.index') }}">Post</a>
            </li>
        </ul>
    </nav>
    <!-- Todos los que implementen esta plantilla tenddran este mismo menu de navegacion pero
            el contenido va a variar
    -->
    {{ $slot }}
</body>
</html>

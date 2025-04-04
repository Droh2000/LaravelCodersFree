<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <script src="https://cdn.jsdelivr.net/npm/@tailwindcss/browser@4"></script>
    <!-- La forma en la que vamos a especificar que va a haber contenido variable es usando los puntos
        insercion usando la directiva "yield"
    -->
    <title>@yield('title')</title>

    <!-- Esta directiva funciona similar a la "yield" solo que esta directiva nos va a permitir
         apilar diferente contenido, Supongamos que queremos incluir de manera dinamica estas etiquetas
         pero dependiendo de donde nos encontremos
    -->
    @stack('meta')

    <!-- El Stack normalmente se usa para definir contenido CSS, JS, etiquetas que se requiere
        en ocaciones definir varias veses, esta directiva tambien las podesmo usar en el otro tipo de compontne
    -->

</head>
<body>
    
    <!-- En la herencia de plantilla no existen los SLOTS -->
    @yield('content')
</body>
</html>
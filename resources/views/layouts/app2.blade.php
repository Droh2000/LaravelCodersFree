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
</head>
<body>
    
    <!-- En la herencia de plantilla no existen los SLOTS -->
    @yield('content')
</body>
</html>
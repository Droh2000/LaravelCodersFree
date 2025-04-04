<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <script src="https://cdn.jsdelivr.net/npm/@tailwindcss/browser@4"></script>
    <!-- Esta variable nos la mandara el usuario pero en caso que no nos mande nada le damos un valor por defect-->
    <title>{{ $title ?? "Pagina Sin titulo" }}</title>
</head>
<body>
    
    <!-- Aqui mostramos todo el contenido que sea variable -->
    {{ $slot }}
</body>
</html>
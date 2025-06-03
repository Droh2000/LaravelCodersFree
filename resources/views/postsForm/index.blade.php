<!-- Cada una de las vistas tendra este mismo componente que renderiza el menu -->
<x-layout>

    <!-- Opcion para crear un nuevo post donde ingresaremos los datos por un Form -->
    <a href="{{ route('posts.create') }}">
        Crear Post
    </a>

    <!-- Mostramos todo el listado de posts obtenidos del controlador -->
    <ul>
        @foreach ($posts as $post)
            <li>
                <!-- Cada uno de los elementos pasara a la ruta para mostrar con su Post en especifico -->
                <a href="{{ route('posts.show', $post->id) }}">
                    {{ $post->title }}
                </a>
            </li>
        @endforeach
    </ul>
    <!-- Como en el controlador estamos usando el metodo de paginacion, aplicamos aqui en la vista para mostrarla -->
    {{ $posts->links() }}
</x-layout>

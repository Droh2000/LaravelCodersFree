<!-- Cada una de las vistas tendra este mismo componente que renderiza el menu -->
<x-layout>

    <a href="{{ route("posts.edit", $post->id) }}">Editar Post</a>

    <!-- Mostramos los datos que nos manda el controlador del Post -->
    <h1>{{ $post->title }}</h1>
    <!-- Entre el modelo Post y Category tenemos una relacion uno a muchos -->
    <p>
        Categoria: {{ $post->category->name }}
    </p>
    <div>
        {{ $post->body }}
    </div>
</x-layout>

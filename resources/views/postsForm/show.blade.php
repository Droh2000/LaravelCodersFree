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

    <!-- Aqui agregamos el apartado para eliminar Post
        Para mandar otro tipo de peticiones que no sean GET/POST tenemos que crearnos un fomrulario, establecer en Method POST
        y dentro usar la directiva @method especificando la peticion que queremos usar

        En "action" indicamos la ruta del controlador responsable de ejecutar la peticion, esta espera el paremetro del ID del post
    -->
    <form action="{{ route('posts.destroy', $post->id) }}" method="POST">
        @csrf
        @method('DELETE')
        <button type="submit">Eliminar</button>
    </form>
</x-layout>

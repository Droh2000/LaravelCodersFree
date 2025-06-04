<!-- Cada una de las vistas tendra este mismo componente que renderiza el menu -->
<x-layout>
    <!--
        Aqui vamos a mostrar los datos obtenidos del Post correpondiente para mostrarlo en el campo de edicion
        Con la funcion "old" le podemos pasar un segundo parametro (Mientras no haya reglas de validacion que hayan fallado
        el valor del segundo parametro es el que muestra). De ahi recuperamos el valor del Post

        Tenemos que  modificar el "action" para procesar la informacion donde ahora apunta a la ruta para actualizar pero espera
        que le pasemos un parametro que es el Id del post

        En el "method" no lo modificamos, A lo Laravel se lo indicamos con la directiva @method, este nos agrega un Input oculto
        con el nombre de "_method", con esto laravel sabe cual solicitud tiene que hacer
    -->
    <form action="{{route('posts.update', $post->id)}}" method="POST">
        @csrf
        @method('PUT')
        <div>
            <label> Titulo del post: </label>
            <input type="text" value="{{ old('title', $post->title) }}" name="title" id="">
            <br>
            @error('title')
                <span>
                    {{ $message }}
                </span>
            @enderror
        </div>
        <hr>
        <div>
            <label>Contenido del post:</label>
            <br>
            <textarea name="body" id="" cols="30" rows="10">{{old('body', $post->body)}}</textarea>
            <br>
            @error('body')
                <span>
                    {{ $message }}
                </span>
            @enderror
        </div>
        <div>
            <label for="">Categorias</label>
            <br>
            <select name="category_id" id="">
                @foreach ($categories as $category)
                    <option @selected(old('category_id', $post->category_id</option>) == $category->id) value="{{$category->id}}">{ $category->name {}}</option>
                @endforeach
            </select>
        </div>
        <hr>
        <button type="submit">Actualizar Post</button>
    </form>
</x-layout>

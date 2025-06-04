<!-- Cada una de las vistas tendra este mismo componente que renderiza el menu -->
<x-layout>
    <!--
        Formulario en el que el usuario va a poder ingresar datos y guardardarlos en la Base de datos

        Ahora si especificamos solo algunos campos y dejamos en blanco otros que son obligatorios, al pulsar el boton de enviar
        por defecto nos elimina todos los datos que hayamos escrito en los campos y nos dejara todo el Form en blanco esto porque nos
        regresa a la ruta anterior pero en ese re-envio nos mandara una variable "errors" con esta podemos detectar en el HTML si hay mensajes
        de validacion por mostrar
        Entonces debemos de mostrar mensajes de error para indicar cuales campos son obligatorios verificando si existe esa variable
    -->
    @if ($errors->any())
        <ul>
            @foreach ($errors as $error)
                <li>
                    {{ $error }}
                </li>
            @endforeach
        </ul>
    @endif

    <form action="{{route('posts.store')}}" method="POST">
        <!--
            Por defecto al inicio al enviar los datos del formulario nos sale: 419 PAGE EXPIRED
            esto es como en la asignacion masiva por los usuarios pueden modificar el html de los formularios donde puede insertar datos que no estan permitidos
            para esto Laravel tiene una proteccion que nos permite enviar formularios usando el metodo POST unicamente si al formulario le damos un Token
            que lo identifique como un formulario que fue creado por nosotros
                Ese Token se agrega con @crsf
            Esto nos da un token oculto que de un nombre identificado que lo reconoce como algo creado por el desarrollador
            cualquier formulario creado por usuarios no tendran este token y laravel sabra que son creados malintencionados
            Este Token tiene un tiempo de vida y si pasa cierto tiempo y el usuario preciona el boton de enviar ya no podra hacerlo
        -->
        @csrf
        <div>
            <!-- Con el nombre especificado en el "name" relacionamos el input al campo especificado de la tabla-->
            <label> Titulo del post: </label>
            <!--
                Evitar que cuando las reglas de validacion fallen nos borren los datos de los campo donde se ingreso datos
                tenemos que recuperar esos datos antes que el usuario envie los datos, para esto en los inputs para recuperar
                los datos le agregamos el argumento "vale" en el metodo Old especificarle el nombre del campo
            -->
            <input type="text" value="{{ old('title') }}" name="title" id="">
            <!-- Esto es por si queremos mejor mostrar el error debajo de cada uno de los campos que dio error indicando el nombre del campo -->
            <br>
            @error('title')
                <span>
                    {{ $message }}
                </span>
            @enderror
        </div>
        <hr>

        <div>
            <label>Slug: </label>
            <input type="text" value="{{ old('slug') }}" name="slug" id="">
            <br>
            @error('slug')
                <span>
                    {{ $message }}
                </span>
            @enderror
        </div>
        <hr>

        <div>
            <label>Contenido del post:</label>
            <br>
            <!-- Asi le hacemos para que el TextArea mantenga los datos registrados por el usuario -->
            <textarea name="body" id="" cols="30" rows="10">{{old('body')}}</textarea>
            <br>
            @error('body')
                <span>
                    {{ $message }}
                </span>
            @enderror
        </div>
        <!-- Para el caso de las categorias en este caso estamos almacenando el ID de las categorias
                Asi que en el controlador recuperamos todas las categorias que tenemos en la base de datos

            Supongamos que un usuario en nuestra pagina para crear, edita el select de las categorias y edita para poner una categorias que no existe para nosotros
            al precionar el boton de enviar, le mostrara una ventana de error de laravel porque aqui agregamos una restriccion de FK no se puede agregar
            una categoria que no exista
            Lo mejor es que para ese caso que falle mostrar un mensaje de error, como en las reglas de validacion
        -->
        <div>
            <label for="">Categorias</label>
            <br>
            <!-- Para saber cual valor selecciono el usuario le especificamos el nombre en "name" -->
            <select name="category_id" id="">
                <!-- Aqui mostramos las categorias -->
                @foreach ($categories as $category)
                    <!-- value toma el valor que seleccionemos
                        En Blade con la directiva "Selected" podemos mantener cual fue de las opciones las que eligio el usuario
                        donde indicamos con un booleano si seleccionamos o no, por tanto primero verificamos si hay error o no de validacion
                        y recuperamos lo que habia antes en el campo, despues preguntamos si ese valor que recuperamos es igual al campo del Value
                        Asi en el caso que falle la regla de validacion y teniamos un valor por defecto, ese valor es el que sera asignado en el Select
                    -->
                    <option @selected(old('category_id') == $category->id) value="{{$category->id}}">{ $category->name {}}</option>
                @endforeach
            </select>
            @error('category_id')
                <span>
                    {{ $message }}
                </span>
            @enderror
        </div>

        <!--
                Aqui vamos a verlo para los demas elementos HTML

            Checkbox:
                En laravel tenemos directivas que le podemos agregar a los elementos, estoas empiezan con '@'
                    @checked(True/False) -> Asi lo seleccionamos o no por defecto
                Asi que con la funcion "old()" preguntamos si alguna regla de validacion fallo y que recupere lo que tenia
                en el campo "active" y lo comparamos si el valor es igual al "value" del input
        -->
        <div>
            <label for="">
                <input type="checkbox" name="active" value="1" @checked(old('active') == 1)>
                Estado
            </label>
        </div>

        <br>

        <button type="submit">Crear Post</button>
    </form>
</x-layout>

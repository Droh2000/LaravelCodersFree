{{--<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <script src="https://cdn.jsdelivr.net/npm/@tailwindcss/browser@4"></script>
    <title>Cursos de Pago</title>
    <style>
        .color-red{
            color: red;
        }
        .color-green{
            color: green;
        }
    </style>
</head>
<body>--}}

<!-- Ya la Plantilla nos proporcionara el codigo HTML
    Todas las vistas que tengan estas plantillas van a tener la misma estrcutura de este codigo

<x-app-layout>

    
        La plantilla espera que le pasemos el nombre de la pagina
    
    <x-slot name="title">
        Posts
    </x-slot>
-->

<!-- Para usar la Herencia de Palantillas, le indicamos donde se encuentra la plantilla -->
@extends('layouts.app2')
    <!-- Asi le pasamos el contiedo variable que espera que le especifiquemos a la plantilla  
        Le damos el nombre correspondiente de la variable y el valor a asignar
    -->
    @section('title', 'Posts')

    <!-- Asi trabajamos con la directiva Stack, al indicarlo dentro le especificamos el contenido
        Esta es la diferencia de usar Push a Yield, Con push podemos apilar contenido
    -->
    @push('meta')
        <meta name="description" content="Cursos de Pagos">
    @endpush
    <!-- 
        Este es el ejemplo del apilamiento en el que al volver a llamar la misma etiqueta este contenido nos lo pondra en donde 
        espesificamos el primer push (Junta todo el contido que le vamos pasando)
    -->
    @push('meta')
        <meta name="keywords" content="laravel, php, cursos">
    @endpush

<!-- Para pasar contenido mas complejo como este codigo HTML tenemos que usar con la directiva endSection -->
@section('content')

    <!-- Usar codigo que esta en otro archivo 
        Si estuviera en otra carpeta seria: NombreCarpeta.NombreVista
        Para mandar parametros solo especificamos en el array: NombreVariable => Contenido
    -->
    @include('prueba', ['color' => 'red'])
    <!-- Con esta si existe el archivo nos trae el codigo pero si no existe solo lo ignora y no nos da error -->
    @includeIf('posts.prueba2')
    <!-- Mostrar el contenido solo si se cumple la condicion -->
    @includeWhen(true, 'prueba2')
    <!-- Para verificar si existen varias vistas y nos traiga la primera de ellas, tiene que existir por lo menos una vista sino dara error -->
    @includeFirst(['prueba3', 'prueba2'])

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

    <!-- 
        Cuando queramos mostrar cierto contenido dependiendo en donde se encuentre desplegada la aplicacion
        Dentro de esta directiva queremos evaluar si nos encontramos en un localhost y el otro si nos encontramos en produccion
        Esto lo detecta por el archivo de configuracion de "app.php" o la variable de entorno
    -->
    @env('local')
        <p>Estamos en Local</p>
    @endenv

    @env('production')
        <p>Estamos en Produccion</p>
    @endenv
    <!-- Otra alternativa a lo de arriba -->
    @production
        <p>Estamos en Produccion 2</p>
    @endproduction

    @switch($dia)
        @case(1)
            <p>Lunes</p>
            @break
        @case(2)
            <p>Martes</p>
            @break
        @case(3)
            <p>Miercoles</p>
            @break
        @case(4)
            <p>Jueves</p>
            @break
        @case(5)
            <p>Viernes</p>
            @break
        @default
            @break
    @endswitch

    <!-- Mostrar el contenido del Array en el HTML -->
    <ul>
        @foreach ( $post as $p )
               <li>
                    <h3>{{$p['title']}}</h3>
                    <p>{{$p['content']}}</p>
               </li>     
        @endforeach
    </ul>

    @forelse ( $posts2 as $p2 )
        <!-- Aqui mostrariamos la informacion si se obtuvo con los datos esperados -->
    @empty
        <!-- Aqui mostramos para el caso que no se obtuvieron datos -->
        <p>No se encontraron datos de la base de datos</p>
    @endforelse

    <!-- Vamos a mostrar tantos * como la cantidad -->
    <ul>
        @for ($i=1; $i<= $cant; $i++)
            <li>
                <!-- Queremos que todos los valores mutliplos de 3 se salten la instruccion de abajo -->
                {{--@if ($i % 3 == 0)
                    <!-- Con este nos saltamos la logica que sigua y continuamos con la siguiente iteracion -->
                    @continue
                @endif--}}

                {{-- Otra misma forma de hacer lo de arriba --}}
                @continue($i % 3 == 0)
                {{-- Si se cumple se sale de todo el bucle --}}
                @break($i % 10 == 0)

                <!-- Esto es para que nos agrege N astediscos por el numero que se esta iterando -->
                @for ($j=1; $j <= $i; $j++)
                    *
                @endfor
            </li>
        @endfor
    </ul>

    <!-- Uso del bucle While con la directiva de PHP para escribir codigo PHP -->
    @php
        $i = 1;
    @endphp

    @while ($i<= $cant)
        <p>*</p>
        @php
            $i++;
        @endphp
    @endwhile

    <!-- La variable LOOP nos va a dar informacion hacerca de la iteracion en la que nos encontramos  
        esta variable se genera automaticamente cada vez que creamos un Bucle
    -->
    <ul>
        @foreach ($post as $p)
            <li>
                <h2>
                    {{ $p['title'] }}
                    <!-- Queremos mostrar algun texto solo si nos encontramos en la primera iteracion -->
                    @if ($loop->first)
                        (Primera iteracion)
                    @endif
                    <!-- Mostrar algo si nos encontramos en la ultima iteraciones -->
                    @if ($loop->last)
                        (Ultima iteracion)
                    @endif
                    <!-- Si queremos saber el indice, iteracion en el que nos encontramos actualmente -->
                    (Indice {{$loop->index}}, Iteracion {{$loop->iteration}}, Iteracion Restante {{$loop->remaining}})

                </h2>

                <p>{{ $p['content'] }}</p>

                <ul>
                    <!-- Este bucle va a tener su propia variable Loop -->
                    @foreach ($p['tags'] as $tag)
                        <li>
                            {{$tag}}
                            @if ($loop->first)
                                (Es el primero)
                            @endif
                            <!-- Tambien vamos a querer acceder a la variable Loop pero de otro bucle, en este caso del bucle padre 
                                De ahi podemos acceder a los demas metodos correspondientes
                            -->
                            @if ($loop->parent->first)
                                (Le pertenece al Primero Post)
                            @endif

                            @if ($loop->parent->last)
                                (Le pertenece al Ultimo Post)
                            @endif

                        </li>
                    @endforeach
                </ul>
            </li>
        @endforeach
    </ul>

    <!-- Con esta directiva podremos agregar clases de manera dinamica a los elementos solo si se cumple determinada condicion 
        Aqui vamos a hacer que el primer Post y ultimo se coloree de un color
    -->
    <ul>
        @foreach ($post as $p)
            <!-- Dentro le especificamos las clases que queremos aplicar -->
            <li @class([
                // Este solo lo queremos aplicar cuando estemos en la primera iteracion
                'color-red' => $loop->first,
                // Este cuando sea la utlima iteracion
                'color-green' => $loop->last
            ])>
                <h2>
                    {{$p['title']}}
                </h2>

                <p>
                    {{$p['content']}}
                </p>
            </li>
        @endforeach
    </ul>

    <form action="">
        <div>
            <!-- Queremos que a los Checkbox agregarle la propiedad "checked" si es que cumple una condicion
                Para esto tenemos esta directiva con el mismo numbre el cual le pasamos una condicion
            -->
            <label for="">
                <input type="checkbox" name="paises[]" id="">
                Peru
            </label>
            <label for="">
                <input type="checkbox" @checked(true) name="paises[]" id="">
                Colombia
            </label>
            <label for="">
                <input type="checkbox" name="paises[]" id="">
                Chile
            </label>
            <label for="">
                <input type="checkbox" name="paises[]" id="">
                Argentina
            </label>
        </div>

        <!-- Esta directiva es similar para seleccionar un checkbox solo que para las listas 
            Para tener por defecto una opcion seleccionada
        -->
        <div>
            <select name="ciudad" id="">
                <option value="1" @selected(true)>Lima</option>
                <option value="2">Nose</option>
                <option value="3">Que poner</option>
            </select>
        </div>

        <div>
            <!-- Para hacer un campo de solo lectura si se cumple una condicion -->
            <input type="text" @readonly(true)>
            <!-- Esta directiva es para obligar a que se tiene que escribir en este campo -->
            <input type="text" @required(true)>
        </div>

        <!-- Esta directiva es para desactivar los botones en base a una condicion -->
        <button @disabled(true)>Enviar</button>
    </form>

    <div class="container mx-auto py-12">
        <h2 class="mb-4">Uso de componentes</h2>
        <hr>
        <!-- 
            Supongmos que hemos obtenido el tipo de alerta en la base de datos y la tenemos almacenada en
            una variable en PHP
        -->
        @php
            $type = 'danger';
        @endphp

        <!-- Para llamar el componente:
                x-NombreComponente
            Podemos mandarle informacion al componente entre las dos etiquetas
            todo el contido que le mandemos se va a guardar en una variable llamada SLOT 
            Podemos pasarles diferentes tipos de Slot, que son los principales (El por defecto)
            y los Slots con nombre

            Hay varias formas para pasarle datos largos a los componentes, el uso de slots es para
            pasarle datos largos
            Otra forma de pasar informacion es atravez de atributos 

            Cuando queremos pasarle codigo PHP a un tributo para que lo interprete le ponemos dos puntos al inicio del nombre
            asi nos ahorramos la sintaxis de "type={{$type}}"

            Si le especificamos clases veremos que no las aplica en este caso los estilos, ya que cualquier cosa que le especifiquemos
            como atributos el componente lo va a interpretar en su constructor (Espera que nosotros se lo hayamos definido ahi)
            Cualquier atributo que definamos ahi y no lo recibamos en el constructor va a quedar almacenado en una variable llamada "attributes"
        -->
        <x-alert :type="$type" class="mb-4">
            <!-- Con este determinamos el nombre de la variable a la que queremos pasare el valor -->
            <x-slot name="title">
                Titulo Dinamico
            </x-slot>

            Contenido Variable
        </x-alert>

        <p> Hola G </p>
    </div>

    <hr>
    <!-- Los componentes anonimos solo llevan una Vista, no una clase 
        Vamos a hacer un componentne que ya nos traiga por defecto unos estilos Responsive
        tambien vamos a hacer que el ancho se lo vamos a proporcionar dinamicamente
    -->
    <x-container width="7xl">
        <p>Contenido De Componente Anonimo</p>
    </x-container>


    {{-- Interactuamos con el Array que le pasamos desde JS --}}
    <script>
        // Primero tenemos que convertir los datos de PHP a un formato que entienda JS
        // Esto nos crea una cadena en formato JSON y para asignarle el valor le ponemos los !!
        //      const posts = {!! json_encode($post) !!};

        // Otra formas mas facil es usar la directiva de Blade
        const posts = @json($post);

        console.log(posts);
    </script>
@endsection
<!-- </x-app-layout>  -->
{{--</body>
</html>--}}
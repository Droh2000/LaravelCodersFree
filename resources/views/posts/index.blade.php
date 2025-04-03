<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
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
<body>
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


    {{-- Interactuamos con el Array que le pasamos desde JS --}}
    <script>
        // Primero tenemos que convertir los datos de PHP a un formato que entienda JS
        // Esto nos crea una cadena en formato JSON y para asignarle el valor le ponemos los !!
        //      const posts = {!! json_encode($post) !!};

        // Otra formas mas facil es usar la directiva de Blade
        const posts = @json($post);

        console.log(posts);
    </script>
</body>
</html>
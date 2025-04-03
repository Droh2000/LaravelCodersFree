{{-- En la clase le especificamos el dato recibido como atributo 
     Para ver todos los atibutos que le mandemos al componente que no esten definidos en el constructor
    Si se los pasamos especificamos al componente para que aplique en este caso el atributo CLASS, por defecto
    nos remplazar el CLASS que ya habiamos definido despues

        <div {{ $attributes }} class={{$class}} role="alert">

    En el caso que le llege el atributo "class" queremos que se fusione con el otro class ya defnindo
    para esto llamamos el metodo merge dentro le colocamos las clases que queremos que se fusionen
--}}
<div {{ $attributes->merge([
    'class' => $class
])}} role="alert">
    <!-- Esta informacion queremos que se muestre con el slot con nombre -->
    <p class="font-bold">{{ $title }}</p>
    <!-- Para acceder al contenido que se nos esta enviando dinamicamente -->
    <p>{{ $slot }}</p>
</div>
<!-- Para recibir los atributos que nos mandan lo hacemos con esta directiva 
    Para que el atributo no sea obligatorio y no de errror si no nos mandan datos 
    la inicializamos
-->
@props([
    // Asi le asignamos un valor por defecto
    'width' => '7xl'
])

<!-- Generamos un case para evlauar el valor del atirbuto -->
@php
    switch ($width) {
        case '7xl':
            $width = 'max-w-7xl';
            break;
        case '4xl':
            $width = 'max-w-4xl';
            break;
        default:
            $width = 'max-w-6xl';
            break;
    }

@endphp

<!-- Si le queremos agregar mas clases ponemos que de los Atributes junte el contiedo de class a la variable class que recibimos -->
<div {{ $attributes->merge([
    //  'class' => 'max-w-7xl mx-auto px-4 sm:px-6 lg:px-8'
    // Concatenamos el valor recibido
    'class' => $width.'mx-auto px-4 sm:px-6 lg:px-8' 
])}}>
    {{ $slot }}
</div>
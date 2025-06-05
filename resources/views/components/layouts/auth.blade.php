<!--
    Este es el componente que se encarga la plantilla del Login que tenemos
    pero vemos que al mismo tiempo este componente esta llamando a otro componente
    que se llama: layouts.auth.simple
    La Razon de usar un componente para llamar otro componente es que el Kit de Inicio
    tres posibles plantillas que podemos elegir para cambiar la apariencia
-->
<x-layouts.auth.simple :title="$title ?? null">
    {{ $slot }}
</x-layouts.auth.simple>

<!--
    Esta plantilla esta llamando a otra llamada Sidebar pero tambien podemos trabajar con otra plantilla llamada Header
-->
<x-layouts.app.sidebar :title="$title ?? null">
    <flux:main>
        {{ $slot }}
    </flux:main>
</x-layouts.app.sidebar>

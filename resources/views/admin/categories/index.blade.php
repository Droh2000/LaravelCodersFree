<!-- Ingresamos a la carpeta "layouts" y nos traiga el componente 'admin'
        Este codifo de Flux lo sacamos de la pagina oficial
-->
<x-layouts.admin>
    <div class="flex justify-between items-center mb-4">
        <flux:breadcrumbs>
            <flux:breadcrumbs.item href="{{ route('admin.dashboard') }}">Dashboard</flux:breadcrumbs.item>
            <!-- Esta es la opcion del menu en el que nos encontramos -->
            <flux:breadcrumbs.item>
                Categorias
            </flux:breadcrumbs.item>
        </flux:breadcrumbs>

        <a class="btn btn-blue text-xs" href="{{route('admin.categories.create')}}">
            Nuevo
        </a>
    </div>

    <!-- Mostrar el listado de las categorias -->
    <div class="relative overflow-x-auto">
        <table class="w-full text-sm text-left rtl:text-right text-gray-500 dark:text-gray-400">
            <thead class="text-xs text-gray-700 uppercase bg-gray-50 dark:bg-gray-700 dark:text-gray-400">
                <tr>
                    <th scope="col" class="px-6 py-3">
                        Id
                    </th>
                    <th scope="col" class="px-6 py-3">
                        Name
                    </th>
                    <th scope="col" class="px-6 py-3" width="200">
                        Edit
                    </th>
                </tr>
            </thead>
            <tbody>
                @foreach ($categories as $category)
                    <tr class="bg-white border-b dark:bg-gray-800 dark:border-gray-700 border-gray-200">
                        <th scope="row" class="px-6 py-4 font-medium text-gray-900 whitespace-nowrap dark:text-white">
                            {{ $category->id }}
                        </th>
                        <td class="px-6 py-4">
                            {{ $category->name }}
                        </td>
                        <td class="px-6 py-4">
                            <div class="flex items-center space-x-2">
                                <a href="{{route('admin.categories.edit', $category)}}" class="text-xs btn btn-green">
                                    Editar
                                </a>

                                <form class="delete-form" action="{{route("admin.categories.destroy", $category)}}" method="POST">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn btn-red text-xs">
                                        Eliminar
                                    </button>
                                </form>
                            </div>
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>

    @push('js')
        <script>
            // Se mantenga a la esucha del evento submit de todos los formulario con la clase ".delete-form"
            document.querySelectorAll('.delete-form').forEach(form => {
                form.addEventListener('submit', (e) => {
                    e.preventDefault();

                    Swal.fire({
                        title: "¿Estas seguro que quieres eliminar?",
                        text: "No podras revertir esto!",
                        icon: "warning",
                        showCancelButton: true,
                        confirmButtonColor: "#3085d6",
                        cancelButtonColor: "#d33",
                        confirmButtonText: "Si, eliminar!",
                        cancelButtonColor: "Cancelar"
                        }).then((result) => {
                        if (result.isConfirmed) {
                            form.submit();
                        }
                    });
                });
            });
        </script>
    @endpush
</x-layouts.admin>

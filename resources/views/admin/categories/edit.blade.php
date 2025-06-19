<x-layouts.admin>
    <div class="mb-4">
        <flux:breadcrumbs>
            <flux:breadcrumbs.item href="{{ route('admin.dashboard') }}">Dashboard</flux:breadcrumbs.item>
            <flux:breadcrumbs.item href="{{ route('admin.categories.index') }}">
                Categorias
            </flux:breadcrumbs.item>
            <flux:breadcrumbs.item>
                Editar
            </flux:breadcrumbs.item>
        </flux:breadcrumbs>
    </div>

    <form action="{{route('admin.categories.update', $category)}}" method="POST" class="bg-white px-6 py-8 rounded-lg shadow-lg space-y-4">
        @csrf
        @method('PUT')
        <!-- Con la funcion "old" si le decimos que en caso que no haya valor, nos regrese el nombre de la categoria-->
        <flux:input name="name" label="Name" value="{{old('name', $category->name)}}"/>

        <div class="flex justify-end">
            <flux:button type="submits" variant="primary">
                Guardar
            </flux:button>
        </div>
    </form>
</x-layouts.admin>

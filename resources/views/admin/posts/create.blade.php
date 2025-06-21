<x-layouts.admin>
    <div class="mb-4">
        <flux:breadcrumbs>
            <flux:breadcrumbs.item href="{{ route('admin.dashboard') }}">Dashboard</flux:breadcrumbs.item>
            <!-- Esta es la opcion del menu en el que nos encontramos -->
            <flux:breadcrumbs.item href="{{ route('admin.posts.index') }}">
                Posts
            </flux:breadcrumbs.item>
            <flux:breadcrumbs.item>
                Nuevo
            </flux:breadcrumbs.item>
        </flux:breadcrumbs>
    </div>

    <form action="{{route('admin.posts.store')}}" method="POST" class="bg-white px-6 py-8 rounded-lg shadow-lg space-y-4">
        @csrf
        <!-- Con la funcion "old" si hay errores de validacion se mantengan los datos escritos-->
        <flux:input name="title" label="Title" value="{{old('title')}}"/>

        <flux:input name="slug" label="Slug" value="{{old('slug')}}"/>

        <!-- Selector para relacionar el Post con una categoria -->
        <flux:select label="Category" name="category_id">
            @foreach ($categories as $category)
                <flux:select.option value="{{$category->id}}">
                    {{ $category->name }}
                </flux:select.option>
            @endforeach
        </flux:select>

        <div class="flex justify-end">
            <flux:button type="submits" variant="primary">
                Guardar
            </flux:button>
        </div>
    </form>
</x-layouts.admin>

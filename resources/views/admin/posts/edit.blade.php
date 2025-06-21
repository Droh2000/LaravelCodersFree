<x-layouts.admin>
    <div class="mb-4">
        <flux:breadcrumbs>
            <flux:breadcrumbs.item href="{{ route('admin.dashboard') }}">Dashboard</flux:breadcrumbs.item>
            <flux:breadcrumbs.item href="{{ route('admin.posts.index') }}">
                Posts
            </flux:breadcrumbs.item>
            <flux:breadcrumbs.item>
                Editar
            </flux:breadcrumbs.item>
        </flux:breadcrumbs>
    </div>

    <form action="{{route('admin.posts.update', $post)}}" method="POST" class="bg-white px-6 py-8 rounded-lg shadow-lg space-y-4">
        @csrf
        @method('PUT')
        <!-- Con la funcion "old" si le decimos que en caso que no haya valor, nos regrese el nombre de la categoria-->
        <flux:input name="title" label="Title" value="{{old('title', $post->title)}}"/>
        <flux:input name="slug" label="Slug" value="{{old('slug', $post->slug)}}"/>
        <!-- Debemos de asegurarnos que en el selector salga elegdia la categoria que ya tenia el Post -->
        <flux:select label="Category" name="category_id">
            @foreach ($categories as $category)
                <!-- Al "selected" le tenemos que pasar un valor booleano cuando sea true esa opcion sera la seleccionada
                        para eso la categoria que estamos iterando coincida con la categoria del post
                        Con  la funcion old() verificamos si hay errores de validacion y que recupere lo ultimo que el usuario selecciono
                        y si no hay errores el valor que tomara por defecto sera la catefgoria del Post
                -->
                <flux:select.option value="{{$category->id}}" :selected="$category->id == old('category_id', $post->category_id)">
                    {{ $category->name }}
                </flux:select.option>
            @endforeach
        </flux:select>

        <!-- Campos de contenido (Aqui en la edicion es donde vamos a agregar el contenido del Post) -->
        <flux:textarea label="Summary" name="excerpt">{{ old('excerpt', $post->excerpt) }}</flux:textarea>

        <flux:textarea rows="12" label="Content" name="content">{{ old('content', $post->content) }}</flux:textarea>

        <div>
            <p class="text-sm font-semibold">Estado</p>

            <label>
                <input type="radio" name="is_published" value="0" @checked(old('is_published', $post->is_published) == 0)>
                No Publicado
            </label>

            <label>
                <input type="radio" name="is_published" value="1" @checked(old('is_published', $post->is_published) == 1)>
                Publicado
            </label>
        </div>

        <div class="flex justify-end">
            <flux:button type="submits" variant="primary">
                Guardar
            </flux:button>
        </div>
    </form>
</x-layouts.admin>

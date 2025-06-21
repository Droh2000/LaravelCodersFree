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
        <!-- Con la funcion "old" si hay errores de validacion se mantengan los datos escritos
            Por el codigo de Js para generar el SLUG de forma automatica requerimos darle ID a los campos
            y que el campo titulo se mantega a la escucha del OnInput que es por cada tecla precionada pasandole el valor
            que tenemos escrito hasta el momento y el otro es el identificador del campo SLUG
        -->
        <flux:input name="title" label="Title" value="{{old('title')}}" oninput="string_to_slug(this.value, '#slug')"/>

        <flux:input name="slug" id="slug" label="Slug" value="{{old('slug')}}"/>

        <!-- Selector para relacionar el Post con una categoria -->
        <flux:select label="Category" name="category_id">
            @foreach ($categories as $category)
                <flux:select.option value="{{$category->id}}" :selected="$category->id == old('category_id')">
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

    <!-- Con este codigo de JS vamos a poder generar SLUGS de forma atomatica
            Hay que recordar que estamos usando la plantilla Admin donde tenemos un Stack JS
            para que ahi metamos todo el codigo JS que usemos
            (Si esto lo requerimos usar mas de una parte de nuestra pagina para no estar copiando y pegando,
            hicimos que se mande a llamar la pieza de codigo)

    push('js')
        <script>

        </script>
    endpush

        Esto se cambio para usar la funcion de manera global en toda la aplicacion
    -->
</x-layouts.admin>

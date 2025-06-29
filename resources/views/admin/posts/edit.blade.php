<x-layouts.admin>

    <!-- Modificaciones para poder editar el texto enriquecidamente -->
    @push('css')
        <link href="https://cdn.jsdelivr.net/npm/quill@2.0.3/dist/quill.snow.css" rel="stylesheet" />

        <link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />
    @endpush

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

    <form action="{{route('admin.posts.update', $post)}}" method="POST">
        @csrf
        @method('PUT')

        <div class="relative mb-2">
            <img id="imgPreview" class="w-full aspect-video object-cover object-center" src="" alt="Image Not Implement">
            <!-- Apartado para subir una imagen, aqui creamos un label y no un boton para poder colocarle un input de tipo file-->
            <div class="absolute top-8 right-8">
                <label class="bg-white px-4 py-2 rounded-lg cursor-pointer">
                    Cambiar Imagen
                    <!-- El input estara a la esucha de la funcion de JS que metimos para previsualiar la imagen -->
                    <input class="hidden" type="file" name="image" accept="image/*" onchange="preview_image(event, '#imgPreview')">
                </label>
            </div>
        </div>

        <div class="bg-white px-6 py-8 rounded-lg shadow-lg space-y-4">
            <!-- Con la funcion "old" si le decimos que en caso que no haya valor, nos regrese el nombre de la categoria-->
            <flux:input name="title" label="Title" value="{{old('title', $post->title)}}"/>

            <!-- si no existe fecha de publicacion es cuando podremos edtiar el SLUG -->
            @if (!$post->published_at)
                <flux:input name="slug" label="Slug" value="{{old('slug', $post->slug)}}"/>
            @endif

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

            <!-- Area para poder agregarle etiquetas al Post -->
            <div>
                <p class="font-medium text-sm mb-2">
                    Etiquetas
                </p>
                <!-- Vamos a seleccionar mas de un elemento y estos se almacenaran en un Array "tags[]"-->
                <select id="tags" name="tags[]" style="width: 100%" multiple="multiple">
                    @foreach ($tags as $tag)
                        <!--
                            Cuando mandamos los datos de las Tags llegaran en array con el ID ($tag->id) correspondiente pero al agregar uno nuevo que no exista en la tabla
                            nos saldra el texto de esta etiqueta, asi que de esa manera en el VALE mandamos mejor el nombre

                            Vamos a hacer para que salgan las etiquetas relacionadas que ya tiene el Post Asignado
                            aqui lo vamos a ver de otra forma a las categorias
                            Accedemos al post recuperamos sus etiquetas de ahi solo queremos el ID para eso usamos el metodo "pluk" para que
                            nos genere una coleccion solo del campo especificado y el resultado lo convertimos a un array
                                $tags = $post->tags->pluck('id')->toArray();

                            En PHP tenemos esta funcion que le podemos pasar un array y preguntar si un elemento existe dentro de ese array
                            regresandonnos True o False
                                $response = in_array(1, $tags);
                            Aqui consultamos el NOMBRE del Tag que estamos iterando (Porque asi estamos trabajando con el Nombre aqui)
                            Ademas usamos la funcion "old()" para verificar si hay error de validacion y si lo hay recupere los datos que tenia ya puestos
                            si no que nos mande los datos que se tienen asignados
                                Si queremos lo que se nos esta retornarn en la vista podemos usar en cualquier parte
                                    @ json(old('tags'))
                        -->
                        <option value="{{ $tag->name }}" @selected(in_array($tag->name, old('tags', $post->tags->pluck('name')->toArray())))>
                            {{ $tag->name }}
                        </option>
                    @endforeach
                </select>
            </div>

            {{--<flux:textarea rows="12" label="Content" name="content">{{ old('content', $post->content) }}</flux:textarea>--}}
            <!-- Se modifico el campo para poder agregar el texto -->
            <div>
                <p class="font-medium text-sm mb-2">
                    Cuerpo
                </p>
                <!-- Esta Libreria nos agrega etiquetas HTML entre el Texto enriquesido y para que no salgan esos elementos ponemos el contenido entre !! -->
                <div id="editor">{!! old('content', $post->content) !!}</div>
                <!-- Solo en un TextArea con estas identificaciones se puede mandar a la BD de para guardar NO en el componente de arriba donde se muestra el editor -->
                <textarea class="hidden" label="Content" name="content">{{ old('content', $post->content) }}</textarea>
            </div>

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
        </div>
    </form>

    @push('js')
        <script src="https://cdn.jsdelivr.net/npm/quill@2.0.3/dist/quill.js"></script>

        <script>
            const quill = new Quill('#editor', {
                theme: 'snow'
            });

            // Para guardar lo que agregemos en el editor se mande a la base de datos, se mandara solo en el TextArea que pusimos abajo
            // vamso a hacer que cuando modiquemos el Editor se modifique lo mismo en el Textarea
            quill.on('text-change', function() {
                document.querySelector('#content').value = quill.root.innerHTML;
            });
        </script>

        <script src="https://code.jquery.com/jquery-3.7.1.min.js" integrity="sha256-/JqT3SQfawRcv/BIHPThkBvs0OEvtFFmqPF/lYI/Cxo=" crossorigin="anonymous"></script>

        <script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>

        <script>
            // Codigo para agregar Etiquetas
            $(document).ready(function() {
                // Dentro del metodo agregamos la logica para poder escribir en el Selector y al precionar enter se agrege y cree como etiqueta
                $('#tags').select2({
                    tags: true,
                    tokenSeparators: [','] // Para que al escribirlas y poner coma automaticamentes se cree como otra etiqueta
                });
            });
        </script>
    @endpush

</x-layouts.admin>

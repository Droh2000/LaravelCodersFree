<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Jobs\ResizeImage;
use App\Models\Category;
use App\Models\Post;
use App\Models\Tag;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Validation\Rule;

class PostController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        // Recuperar el listado de posts pero los vamos a retornar paginados (Esto por defecto nos retornar un JSON)
        $posts = Post::latest('id')->paginate();
        return view('admin.posts.index', compact('posts'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        // Los posts se relacionan con Categorias
        $categories = Category::all();

        return view('admin.posts.create', compact('categories'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        // Esto es lo que se ejecutando cuando damos en Submit al formulario
        // Agregamos las validaciones
        $data = $request -> validate([
            'title' => 'required|string|max:255',
            'slug' => 'required|string|max:255|unique:posts,slug', // El campo debe ser unico en la tabla Posts en el campo Slug
            'category_id' => 'required|exists:categories,id',
        ]);

        // Agregar la relacion de los datos con el Usuario que tendra relacion con el Post
        // acccediendo a la informacion del usuario autenticado y tomar su ID
        // Al metodo "auth" le especificamos el GUARD con el vamos a trabajar (Aqui especificamos el tipo de autenticacion, en este caso es
        // en base a sessiones pero tambien esta la de Tokens)
        $data['user_id'] = auth('web')->id();

        $post = Post::create($data);

        // Aqui mostramos que nos salga un Alerta de SweetAlert pero para que nos aparesca tenemos que configurar su JS en la vista
        // a donde esta redireccionando que en este caso es en la pagina de Edit
        session()->flash('swal', [
            'icon' => 'success',
            'title' => 'Post Creado!',
            'text' => 'El Post se ha creado correctamente',
        ]);

        // Redireccionamos a la pagina de edit por si el usuario quiere seguir edtando
        return redirect()->route('admin.posts.edit', $post);
    }

    /**
     * Display the specified resource.
     */
    public function show(Post $post)
    {
        return view('admin.posts.show', compact('post'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Post $post)
    {
        $categories = Category::all();

        // Obtenemos todas las etiquetas
        $tags = Tag::all();

        return view('admin.posts.edit', compact('post', 'categories', 'tags'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Post $post)
    {
        // Aqui llegan los datos despues de Editar un posr
        $data = $request->validate([
            'title' => 'required|string|max:255',
            // Que sea unico en la tabla posts en el campo slug excluyendo el registro que estamos editando
            //  'slug' => 'required|string|max:255|unique:posts,slug,' . $post->id,
            // La regla de validacion para el SLUG cambio
            'slug' => [
                // Accedemos a esta regla en forma de metodo para poder agregarle esta funcion anonima
                // Si no tenemos nada en el campo "published_at" entones es requerido caso contrario no lo es (Regresamos True or False)
                // Al ser una funcion anonima no podemos acceder a la variable "$post" por eso usamos use($post)
                Rule::requiredIf( function() use($post) {
                    return !$post->published_at;
                }),
                'string',
                'max:255',
                //'unique:posts, slug,'. $post->id
                // La linea de arriba es equivalente a la de abajo
                Rule::unique('posts')->ignore($post->id)
            ],
            'image' => 'nullable|image|max:2048',
            'category_id' => 'required|exists:categories,id',
            // Solo es requerido si el valor de publicacion esta activo
            'excerpt' => 'required_if:is_published,1|string',
            'content' => 'required_if:is_published,1|string',
            'tags' => 'array',
            'is_published' => 'boolean',
        ]);

        //Verificamos si estamos mandando un archivo en el campo llamado "image"
        if($request->hasFile('image')){
            // Subir la imagen al servidor
            // Primero tenemos que indicar en que disco queremos subirlo, tenemos el public, local, S3, entre otros
            // Luego en el metodo PUT indicamos en que subcarpeta queremos que se suba, como segundo parametro le pasamos el archivo a subir
            //              Storage::disk('local')->put('posts', $request->image);
            // El archivo se subira dentr de: Storage/app/private/"NombreIndicadoArriba"
            // Esto es un disco privado y luego la informacion que subamos no vamos a poder mostrarlo en nuestro sitio web
            // Una forma resumida de la linea de codigo es omitir la parte de DISK
            // Esto se subira al disco que tengamos configurado en: config/filesystems en la parte de "FileSystem_DISK"
            //          Storage::put('posts', $request->image);

            // Para poder mostrar la imagen subida en nuestra pagina tenemos que subirla al disco publico
            // En la variable de entorno cambiamos la variable por public: FILESYSTEM_DISK=public
            // Direccion: Storage/app/public/posts/IMAGEN
            // Para acceder a esta carpeta y mostrar la imagen en la pagina, tenemos que crear un acceso directo desde la carpeta public hacia la carpeta donde esta la imagen
            // Crear el acceso diecto:
            //          php artisan storage:link
            // en caso que ya la tengamos creada nos saldra un mensaje de error

            // Cuando un post ya tenia una imagen asociada y le subimos otra imagen, la imagen que ya tenia se mantiene y no se borra
            // la idea es borrando a medida que vayamos actualizando las imagenes
            // Si hay algo en el campo "image_path" significa que ya teniamos subido algo previamente
            if ( $post->image_path ) {
                // Borramos la ruta de la imagen que tiene asociada
                Storage::delete($post->image_path);
            }

            // En esta pare salieron otras lineas de codigo porque en el curso se le olvido subir el video donde explica eso
            // Este codigo le daba el nombre a las imagenes como se tenian el SLUG asociado al POST pero podemos cambiar el SLUG de un post
            // y el nombre de la imagen se mantiene, luego resulta que en otro POST le damos el SLUG que tenia el post al que se lo cambiamos
            // si a este post que le dimos el SLUG que tenia el otro, le subimos una imagen esta va a eliminar la imagen con el nombre del SLUG del post que le cambiamos
            // Asi que vamos a modificar el nombre para que se mantenga la imagen tanto para el post con cambio de SLUG como el post con el SLUG que tenia el otro post
            $extension = $request->image->extension();
            $nameFile = $post->slug . '.' . $extension;
            // Verificamos si existe la imagen
            // Usamos un While y no un IF porque si ya existe la imagen con el nombre "copia" que le vaya agregando este texto "copia" conforme sea nesecario para evitar que la imagen sea remplazada
            while (Storage::exists('posts/' . $nameFile)) {
                // Remplazamos el nombre, como primer parametro le indicamos lo que le queremos cambiar, luego por lo nuevo que sera cambiado, como tercer parametro el valor original a remplazar
                $nameFile = str_replace('.' . $extension, '-copia.' . $extension, $nameFile);
            }

            // Asociar la imagen que estamos subiendo con el POST correspondiente
            // Aqui en esta linea se nos esta retornando la ruta donde tenemos almacenada la imagen, asi que se le asignamos al campo de data donde tendremos la ruta
            $data['image_path'] = Storage::putFileAs('posts', $request->image, $nameFile);

            // Luego que la imagen se a subido llamamos al JOB
            ResizeImage::dispatch($data['image_path']);
        }

        // Cuando se ejecuta este metodo se emite el Observer y realiza la accion
        $post->update($data);

        // Etiquetas
        $tags = [];
        // Del request recuperamos lo que se mando en el arreglo de Tags, pero este puede ser NUll
        // para que no nos de error solo recorrera el bucle si hay datos y si es NULL solo le colocamos un array vacio
        foreach ($request->tags ?? [] as $tag) {
            // Buscar las etiquetas en la BD y recuperarla, si no existe en a BD que la cree
            // buscandola por el campo NAME
            $tags[] = Tag::firstOrCreate(['name' => $tag]);
        }

        // Accedemos al post que estamos intentando actualizar, acceder a la relacion que tiene con etiquetas
        // y que se sincronize con el grupo de etiquetas que tenemos en el arreglo
        $post->tags()->sync($tags);

        session()->flash('swal', [
            'icon' => 'success',
            'title' => 'Post Actualizado!',
            'text' => 'El Post se ha actualizado correctamente',
        ]);

        return redirect()->route('admin.posts.edit', $post);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Post $post)
    {
        //
    }
}

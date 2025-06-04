<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class PostRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    // Con este metodo controlamos las peticiones que hacemos, el valor de retorno lo cambiamos a True
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        // Como estamos usando el mismo Form Request ya sea para edicion o para recuest
        // si nos vamos al de Crear Post la variable "$this->post" nos estara mandando NULL
        // Asi que verificamos si tenemos algo en esa variable
        if($this->post){
            // De existir almacenamos el ID y le concatenamos un Coma adelante porque asi se la tenemos que enviar al metodo
            // de validacion del slug
            $post_id = ',' . $this->post->id;
        }else{
            $post_id = '';
        }

        // Aqui colocamos las reglas de validacion que queremos reutilizar
        return [
            'title' => 'required',
            // Agregamos una regla adicional, para eso pusimos la barra |
            // Despues indicamos que ese campo debe ser unico y lo debe comparar en la tabla Post, con esto laravel verifica
            // que esta llegando en el campo Slug sea unico en el campo Slug de la tabla Post, pero en el caso que el campo de la tabla
            // no conicida con el valor que tenemos aqui colocamos Coma y especificamos en cual campo queremos que haga la comparacion
            //      'slug' => 'required|unique:posts, slug',
            // Esta es otra forma de agregar la regla de validacion
            // Esto ya no funcionara mostrando el mensaje en el HTML pero al querer editar, nos saldra que tenemos un problema, porque si queremos editar
            // queremos que compruebe que en efecto sea un Slug unico pero que omita la verificacion con sigo mismo (Con el Id del registro que estamos editando)
            // Colocamos una segunda Coma y le especificamos el Id con el cual no queremos que haga la verificacion ($this->post Recuperamos el valor del parametro Post $post que nos mandan al controlador)
            'slug' => ['required','unique:posts, slug' . $post_id],
            'body' => 'required',
            // Tambien vamos a verificar que ese valor que tengamos en el Selector debe de existir en la tabla de Cateogrias de la BD
            // a esto le mandamos el nombre de la tabla y por que campo queremos que tome para verficar, asi si mandamos un valor que no existe
            // nos mostrara un mensaje de error
            'category_id' => 'required|exists:categories,id',
        ];
    }
}

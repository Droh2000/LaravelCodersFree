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
        // Aqui colocamos las reglas de validacion que queremos reutilizar
        return [
            'title' => 'required',
            'body' => 'required',
            'category_id' => 'required',
        ];
    }
}

<?php

namespace App\View\Components;

use Closure;
use Illuminate\Contracts\View\View;
use Illuminate\View\Component;

class Alert extends Component
{
    // Cualquier propiedad publica va a poder se accedido a en componente blade
    public $class;

    /**
     * Create a new component instance.
     */
    // Las atributos que especificemos en el componente los vamos a recibir aqui
    // Para que no sean obligatorios y evitar errores si no los definimos le damos un valro por defecto
    public function __construct($type='danger')
    {
        // Vamos a cambiar el tipo de alerta segun el parametro enviado
        switch ($type) {
            case 'info':
                $this->class = 'bg-blue-100 border-l-4 border-orange-500 text-blue-700 p-4';
                break;
            case 'danger':
                $this->class = 'bg-red-500 text-white font-bold rounded-t px-4 py-2';
                break;
            default:
                # Estos por defecto
                $this->class = 'p-2 bg-indigo-800 items-center text-indigo-100 leading-none lg:rounded-full flex lg:inline-flex';
                break;
        }
    }

    /**
     * Get the view / contents that represent the component.
     */
    public function render(): View|Closure|string
    {
        return view('components.alert');
    }
}

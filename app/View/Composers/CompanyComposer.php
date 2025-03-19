<?php
// Supongamos que tenemos que compartir varias variables con diferentes vistas o cosas que requieren mucha logica 
// Podemos dividir el trabajo a archivos que se conocen como composers
// Para esto no tenemos comando de artisan asi que tenemos que crear esto manual

namespace App\View\Composers;

use Illuminate\View\View;

class CompanyComposer{

    // A la funcion le pasamos el objeto como argumento, este objeto sera una instancia de la clase View
    public function compose(View $view){
        // Aqui ya podemos agregar toda la logica que queramos
        $view->with('prueba2','Este es un mensaje de prueba');
    }
    // Para eso nos sirven los composers para definir variables y compartirlo solo a paginas en especificas
}

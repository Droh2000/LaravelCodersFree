<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class HomeController extends Controller
{
    /*public function index(){
        return "Hola desde la pagina principal";
    }
        
        Este controlador va a tener un unico metodo y cuando esto pasa lo mejor es usar los metodos
        invocables el cual se nombre __invoke, ya dentro le metemos la logica
    */
    public function __invoke()
    {   
        return "Hola desde la pagina principal";
    }

}

<?php

namespace App\Jobs;

use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Queue\Queueable;

// Los JOBS por defecto trabajan con colas, para que funcione su uso tenemos que configurar en las variables de entorno
// QUEUE_CONNECTION=database -> Esto quiere decir que se pondra en cola creando un reguistro en la base de dtos en una tabla llamada JOBS
// Para ejecutar la cola tenemos que ejecutar:
//          php artisan queue:work
// Para trabajar esto en produccion tenemos que usar: Supervisor Configuration
// que nos permite tener encendido el comando de queue:work
// Otra forma mas facil
// QUEUE_CONNECTION=sync -> Esto no los pone en cola, solo ejecuta automaticamente el proceso
class ResizeImage implements ShouldQueue
{
    use Queueable;
    public $image_path;

    /**
     * Create a new job instance.
     */
    // Desde el controlador vamos a llamar a esta clase JOB y le especificamos los argumentos que queremos usar de la imagen
    public function __construct($image_path)
    {
        $this->image_path = $image_path;
    }

    /**
     * Execute the job.
     */
    public function handle(): void
    {
        // Aqui va logica para Comprimir automaticamente las imagenes subidas y cambiar de tamaño
        // No se puso porque nos salteamos esas clases
    }
}

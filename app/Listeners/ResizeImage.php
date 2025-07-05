<?php

namespace App\Listeners;

use App\Events\UploadedImage;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;

// Si queremos que el Listener se ejcute en Cola tenemos que agregarle: implements ShouldQueue
// Esto para el caso que realizemos una tarea pesada que ocupe procesamiento
class ResizeImage
{
    /**
     * Create the event listener.
     */
    public function __construct()
    {
        //
    }

    /**
     * Handle the event.
     */
    public function handle(UploadedImage $event): void
    {
        // Aqui Irira la logica que se vio para comprimir la imagen y cambiar de tamano pero se Omitio porque si
        // Ahora usamos el $event para acceder a la propiedad que requiramos usar
    }
}

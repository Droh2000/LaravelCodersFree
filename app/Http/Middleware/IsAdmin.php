<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class IsAdmin
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        // Dentro del $request podremos recuperar la informacion del usuario autneticado y despues podemos preguntar si en el campo
        // is_admin tenemos 0 o 1
        if($request->user()->is_admin == 0){
            // Significa que no es Admin asi que no le permitimos el paso
            return redirect()->route('home'); // Cualquier ruta no permitida nos mandara a Home
        }

        return $next($request);
    }
}

<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\Response;

class CheckRole
{
    /**
     * Handle an incoming request.
     * @param string ...$roles
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next, ...$roles): Response
    {

        //verificando que el usuario este logueado y tenga la relacion 'rol cargada
        if(!Auth::check() || !Auth::user()->rol){
            return redirect('login');
        }

        //OBTENIENDO EL NOMBRE DEL ROL DEL USUARIO
        $userRole = Auth::user()->rol->nombreRol;

        //COMPARANDO SI EL ROL DEL USUARIO ESA EN LA LISTA DE LOS ROLES PERMITIDOS
        if(!in_array($userRole,$roles)){
            abort(403, '¡Acceso no autorizado!');
        }
        return $next($request);
    }
}

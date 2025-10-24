<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Support\Facades\Auth;

class RoleMiddleware
{
    /**
     * Maneja la solicitud entrante y verifica el rol del usuario.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @param  string  $role
     * @return mixed
     */
    public function handle($request, Closure $next, $role)
    {
        // Si no está logueado o no tiene el rol requerido
        if (!Auth::check() || !Auth::user()->hasRole($role)) {
            abort(403, 'No tienes acceso a esta sección');
        }

        return $next($request);
    }
}

<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;

class AdminMiddleware
{
    public function handle(Request $request, Closure $next)
    {
        // Verifica si el usuario está autenticado y es administrador
        if (auth()->check() && auth()->user()->is_admin) {
            return $next($request);
        }

        abort(403, 'Acceso no autorizado. Zona exclusiva para administradores.');
    }
}
<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;

class CheckMembership
{
    public function handle(Request $request, Closure $next)
    {
        if (auth()->check()) {
            $user = auth()->user();

            // Si es administrador, tiene vía libre siempre
            if ($user->is_admin) {
                return $next($request);
            }

            // Si la membresía NO está activa, lo mandamos a una vista de aviso amigable
            if ($user->membership_status !== 'active') {
                return redirect()->route('membership.pending');
            }
        }

        return $next($request);
    }
}
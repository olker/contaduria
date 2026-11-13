<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;

class CheckMembership
{
    public function handle(Request $request, Closure $next)
    {
        $user = $request->user();

        if (!$user || $user->hasActiveMembership()) {
            return $next($request);
        }

        return redirect()->route('membership.pending');
    }
}

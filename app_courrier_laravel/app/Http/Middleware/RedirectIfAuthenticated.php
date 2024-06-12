<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\Response;

class RedirectIfAuthenticated
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @param  string[]  ...$guards
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function handle(Request $request, Closure $next, string ...$guards): Response
    {
        // If no guards are specified, use the default guard
        $guards = empty($guards) ? [null] : $guards;

        foreach ($guards as $guard) {
            // vérifie si l'utilisateur est authentifié avec la garde spécifiée
            if (Auth::guard($guard)->check()) {
                // Si l'utilisateur est authentifié, il est redirigé vers la route accueil
                return redirect()->route('accueil');
            }
        }

        // If not authenticated, allow the request to proceed
        return $next($request);
    }
}

<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\Response;

class CheckPrivilege
{
    public function handle(Request $request, Closure $next, $privilege)
    {
        // Vérifiez si l'utilisateur est connecté
        if (Auth::check()) {
            // Récupérez le niveau de privilège de l'utilisateur
            $userPrivilege = Auth::user()->privilege_user;
            // Vérifiez si le niveau de privilège de l'utilisateur est suffisant
            if ($userPrivilege >= $privilege) {
                // L'utilisateur a le niveau de privilège requis, laissez-le accéder à la route
                return $next($request);
            }
        }
        // Redirigez l'utilisateur vers une page d'erreur ou une page d'accès refusé
        return redirect()->route('acces-refuse');
    }
}

<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class CheckPrivilege
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @param  int  $privilege
     * @return mixed
     */
    public function handle(Request $request, Closure $next, $privilege)
    {
        // Vérifiez si l'utilisateur est connecté
        if (Auth::check()) {
            // Récupérez le niveau de privilège de l'utilisateur connecté
            $userPrivilege = Auth::user()->privilege_user;

            // Vérifiez si le niveau de privilège de l'utilisateur est suffisant
            if ($userPrivilege >= $privilege) {
                // L'utilisateur a le niveau de privilège requis, laissez-le accéder à la route
                return $next($request);
            }
        }

        // Redirigez l'utilisateur vers une page d'erreur ou une page d'accès refusé s'il n'est pas connecté ou n'a pas le privilège requis
        return redirect()->route('acces_refuse')->with('error', 'Vous n\'avez pas les autorisations nécessaires pour accéder à cette page.');
    }
}

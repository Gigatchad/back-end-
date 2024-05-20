<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AdminAuthenticate
{
    public function handle(Request $request, Closure $next)
    {
        // Vérifier si l'utilisateur est authentifié en tant qu'administrateur
        if (Auth::check() && Auth::user()->isAdmin()) {
            return $next($request);
        }

        // Rediriger l'utilisateur vers la page de connexion s'il n'est pas authentifié en tant qu'administrateur
        return redirect()->route('login');
    }
}

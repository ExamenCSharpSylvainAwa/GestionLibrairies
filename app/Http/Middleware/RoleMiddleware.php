<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class RoleMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next, $role): Response
    {
        // Vérifie si l'utilisateur est connecté et a le rôle spécifié
        if ($request->user() && $request->user()->isGestionnaire() && $role === 'gestionnaire') {
            return $next($request);
        }

        // Si l'utilisateur n'a pas le rôle requis, retourne une erreur 403
        abort(403, 'Accès non autorisé. Vous devez être gestionnaire pour accéder à cette page.');
    }
}

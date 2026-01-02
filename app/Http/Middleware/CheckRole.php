<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class CheckRole
{
    /**
     * Gérer l'accès selon le rôle.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @param  string  $role
     * @return mixed
     */
    public function handle(Request $request, Closure $next, $role)
    {
        if (!Auth::check()) {
            // Non connecté → redirige vers login
            return redirect()->route('login');
        }

        // Si le rôle ne correspond pas
        if (Auth::user()->role != $role) {
            abort(403, 'Accès interdit.');
        }

        return $next($request);
    }
}
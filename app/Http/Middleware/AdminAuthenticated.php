<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AdminAuthenticated
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure(\Illuminate\Http\Request): (\Illuminate\Http\Response|\Illuminate\Http\RedirectResponse)  $next
     * @return \Illuminate\Http\Response|\Illuminate\Http\RedirectResponse
     */
    public function handle(Request $request, Closure $next)
    {
        if (Auth::check()){
            $user = Auth::user();
            // on va apres verifier si l'utilisateur est un administrateur;
            if($user->role === 'administrateur'){
                return $next($request);

            }
        }
    //    si l'utilisateur n'est pas un admin on va l'afficher un erreur;
         return abort(403, 'Access Denied');
    }
}

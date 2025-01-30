<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ProfesseurAuthenticated
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
        if(Auth::check()){
            $user = Auth::user();
            // on va verifier si l'utilisateur est un professeuuurr
            if($user->role === 'professeur'){
                return $next($request);
            }
        }
        // si n'est pas un prof un erreur s'affiche;
        return abort(403, 'Access Denied');
    }












}
<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class EtudiantAutheticated
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
            // on doit verifier si lutilisateur a le role etudiant.
            if($user->role=== 'etudiant'){
             
                return $next($request);
            }
            }
    //   si luser n'est pas un etudiant authentifier
       return redirect()->route('login'); 
    //    on va le rediriger ver login

    }
}

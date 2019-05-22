<?php

namespace App\Http\Middleware;

use Auth;

class CheckCard extends Middleware
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @param  string|null  $guard
     * @return mixed
     */
    public function handle($request, Closure $next)
    {
        $user = Auth::user();

        if ($user->card_verification == false) {
            return redirect()->back()->with('error', 'Su tarjeta no ha sido verificada, intente más tarde');
        }
        
        return $next($request);
    }
}

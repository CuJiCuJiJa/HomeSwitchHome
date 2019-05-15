<?php

namespace App\Http\Middleware;

use Closure;


class RedirectIfAuthenticated
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
        $id = Auth::user()->id;
        $user = User::find($id);

        if ($user->card_verification == false) {
            return redirect()->back()-with('error', 'Número de tarjeta no validado, intente más tarde');
        }

        return $next($request);
    }
}

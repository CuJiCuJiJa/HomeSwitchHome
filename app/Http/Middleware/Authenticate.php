<?php

namespace App\Http\Middleware;

use Illuminate\Auth\Middleware\Authenticate as Middleware;
use App\Auction;
use Carbon\Carbon;
class Authenticate extends Middleware
{
    /**
     * Get the path the user should be redirected to when they are not authenticated.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return string
     */
    protected function redirectTo($request)
    {
        /////////////////////////////////////////////
        $auctions = Auction::all();

        $now = Carbon::now();

        foreach ($auctions as $auction) {

            if ($auction->start_date < $now) {
                $auction->active = true;
                $auction->save();
            }
            if ($auction->end_date < $now) { //SI LA SUBASTA YA CUMPLIÓ SU CICLO LA DESACTIVO
                $auction->active = false;
                $auction->save();
            }
        }
        //////////////////////////////////////////////

        if (! $request->expectsJson()) {
            return route('login');
        }
    }
}

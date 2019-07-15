<?php

namespace App\Http\Middleware;

use Closure;
use App\Auction;
use Carbon\Carbon;

class CheckAuction
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @param  string|null  $guard
     * @return mixed
     */
    public function handle($id, Closure $next)
    {
        $trashedAuction = Auction::onlyTrashed($id);


        /* $auctions = Auction::all();

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
        } */
        return $next($id);
    }
}

<?php

namespace App\Http\Middleware;

use Closure;
use App\Auction;
use Carbon\Carbon;

class CheckAuction extends Middleware
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
        $auctionId = $request->route()->parameter('auction');
        $auction = Auction::find($auctionId);
        $now = Carbon::now();

        if ($auction->endDate < $now) { //SI LA SUBASTA YA CUMPLIÓ SU CICLO LA DESACTIVO
            $auction->active = false;
            $auction->save();
        }
        
        return $next($request);
    }
}

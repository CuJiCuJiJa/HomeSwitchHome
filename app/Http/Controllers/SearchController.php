<?php

namespace App\Http\Controllers;

use App\Auction;
use Carbon\Carbon;

use Illuminate\Http\Request;

class SearchController extends Controller
{
    public function getSearchAuction()
    {
    	return view('search.auctionSearch');
    }

    public function postSearchAuction(Request $request)
    {
        //LA BÚSQUEDA SE PODRÁ FILTRAR POR LA UBICACIÓN, SEMANA EN LA QUE SE VA A OCUPAR LA RESIDENCIA
        dd($request);
    	$now = Carbon::now();

        $auctions = Auction::with('home')->where('active', TRUE)->where('starting_date', '<' ,$now)->get();
        $results = collect();

		if ($request->has('location')) {
    		foreach ($auctions as $auction) {
                if ($auction->home->location == $request->location) {
                    $results->push($auction);
                }
            }
		}

		if ($request->has('week')) {
		    foreach ($auctions as $auction) {
                if ($auction->week == $request->week) {
                    $results->push($auction);
                }
            }
		}

		if (!$results->count() > 0) {
            return view('search.auctionResults')->with('error', 'No hay resultados.');
        }


		return view('search.auctionResults')->with('auctions', $results);
    }

    public function getSearchHome()
    {
        return view('search.homeSearch');
    }

    public function postSearchHome(Request $request)
    {
        //LA BÚSQUEDA SE PODRÁ FILTRAR POR LA UBICACIÓN, SEMANA EN LA QUE SE VA A OCUPAR LA RESIDENCIA
    	$now = Carbon::now();
        $homes = Home::all();
        $activeHomes = collect();
        $results = collect();

        if ($home != null) {
            foreach ($homes as $home) {
                if ($home->isOcuppied($request->$week)) {
                    $activeHomes->push();
                }
            }
        }

		if ($request->has('location')) {
    		foreach ($activeHomes as $i) {
                if ($i->home->location == $request->location) {
                    $results->push($i);
                }
            }
		}

		if ($request->has('week')) {
		    foreach ($activeHomes as $i) {
                if ($i->week == $request->week) {
                    $results->push($i);
                }
            }
		}

		if (!$results->count() > 0) {
            return view('search.homeResults')->with('error', 'No hay resultados.');
        }


		return view('search.homeResults')->with('homes', $results);
    }

    public function getSearchHotsale()
    {
        return view('search.hotsaleSearch');
    }

    public function postSearchHotsale()
    {
        $now = Carbon::now();
        $hotsales = Hotsale::all();
        $results = collect();

		if ($request->has('location')) {
    		foreach ($hotsalea as $i) {
                if ($i->home->location == $request->location) {
                    $results->push($i);
                }
            }
		}

		if ($request->has('week')) {
		    foreach ($hotsalea as $i) {
                if ($i->week == $request->week) {
                    $results->push($i);
                }
            }
		}

		if (!$results->count() > 0) {
            return view('search.hotsaleResults')->with('error', 'No hay resultados.');
        }


		return view('search.hotsaleResults')->with('hotsales', $results);
    }
}

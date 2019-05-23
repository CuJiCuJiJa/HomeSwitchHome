<?php

namespace App\Http\Controllers;

use App\Auction;

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

}

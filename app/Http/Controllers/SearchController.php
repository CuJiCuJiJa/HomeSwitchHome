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
    	$auctions = Auction::with('home')->get();
        $results = collect();
    	//el campo 'home' dentro del whereHas llama la funcion home del modelo auction que me trae el home relacionado a la subasta, utilizo $q para acceder al campo location del modelo home relacionado

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

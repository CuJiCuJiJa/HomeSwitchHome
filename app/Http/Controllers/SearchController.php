<?php

namespace App\Http\Controllers;

use App\Auction;

use Illuminate\Http\Request;

class SearchController extends Controller
{
    public function getSearchAuction()
    {
    	return view('auction.search');
    }

    public function postSearchAuction(Request $request, Auction $auction)
    {
    	//LA BÚSQUEDA SE PODRÁ FILTRAR POR LA UBICACIÓN, SEMANA EN LA QUE SE VA A OCUPAR LA RESIDENCIA
    	$auction = $auction->newQuery();

    	//el campo 'home' dentro del whereHas llama la funcion home del modelo auction que me trae el home relacionado a la subasta, utilizo $q para acceder al campo location del modelo home relacionado
		if ($request->has('location')) {
    		$auction->whereHas('home', function($q) use ($request)
    			{
    				$q->where('location', $request->input('location'));
    			});
		}

		if ($request->has('week')) {
		    $auction->where('week', $request->input('week'));
		}

		$auction->get();
		   
		return view('auction.searchResults')->with('auctions', $auction);
    }

}

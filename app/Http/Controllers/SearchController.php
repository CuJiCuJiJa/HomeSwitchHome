<?php

namespace App\Http\Controllers;
use App\Home;
use App\Auction;
use Carbon\Carbon;
use Illuminate\Support\Facades\Input;
use Auth;
use App\User;
use Illuminate\Http\Request;
use Illuminate\Support\Collection;

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

        $auctions = Auction::with('home')->where('active', TRUE)->get();


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
        $results = $results->unique();

		if (!$results->count() > 0) {
            return view('search.auctionResults')->with('error', 'No hay resultados.');
        }


		return view('search.auctionResults')->with('auctions', $results);
    }

    public function getSearchHome()
    {
        $homes = Home::all();
        return view('search.reservationSearch');
    }

    public function postSearchHome(Request $request)
    {
        //LA BÚSQUEDA SE PODRÁ FILTRAR POR LA UBICACIÓN, SEMANA EN LA QUE SE VA A OCUPAR LA RESIDENCIA

        $homes = Home::all();    //Todas las casas disponibles
        $activeHomes = collect();   //Variable donde alojar los resultados validos de la busqueda

        $currentWeek = Carbon::parse($request->fromDate)->startOfWeek(); //Variable auxiliar para la busqueda de casas disponibles por semana
        $endWeek = Carbon::parse($request->toDate)->startOfWeek();; //Semana limite de busqueda

        if ($homes != null) {          //si existe alguna casa
            while ( $currentWeek <= $endWeek){ //Mientras este dentro del rango de busqueda de semanas

                foreach ($homes as $home) {         //por cada casa que exista
                    if (!$home->isOccupied($currentWeek)) { //si no esta ocupada la semana

                        $reservation = ['home'=>$home, 'week'=> $currentWeek->toDateString()];    // creo un arreglo con la casa libre y la semana en la que esta libre
                        $activeHomes->push($reservation); //lo guardo en la variable de casas disponibles
                    }
                }
                $currentWeek = $currentWeek->addWeek(1); //sumo una semana para avanzar en el rango de busqueda
            }
        }

        if ($request->location != null) { //una vez que tengo todas las casas disponibles si existe criterio de busqueda por lugar
            $locationHomes = collect(); //creo una coleccion donde guardar aquellas que cumplan con la localidad
            foreach ($activeHomes as $i) { //recorro todas las activas
                if ($i['home']->location == $request->location) { //si la localidad coincide
                    $locationHomes->push($i); //guardo el arreglo casa-semana en locations
                }
            }
            $activeHomes = $locationHomes; //active es igual a location
        }

     	if (!$activeHomes->count() > 0) {
            return view('search.reservationResults')->with('error', 'No hay resultados.'); //si no hub resultados
        }

		return view('search.reservationResults')->with('reservations', $activeHomes);
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

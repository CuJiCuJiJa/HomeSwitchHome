<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Auth;
use App\Auction;
use Carbon\Carbon;
use App\User;

class PageController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        //  $this->middleware('auth');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index()
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
        return view('page');
    }

    public function testFunction()
    {
        $date = '2019-12-16';
        dd($user->validUser($date));
    }
}

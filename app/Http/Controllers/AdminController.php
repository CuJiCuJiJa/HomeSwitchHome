<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Auth;
use App\Auction;
use Carbon\Carbon;
use App\AuctionUser;
use App\User;

class AdminController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }

    public function markAsAdmin(User $user)
    {
        $user->role_id = 1;
        $user->save();

        return redirect()->route('user.show', $user)->with('success', 'Usuario administrador creado');
    }

    public function markAsPremium(User $user)
    {
        $user->role_id = 2;
        $user->save();

        return redirect()->route('user.show', $user)->with('success', 'Usuario marcado como premiun');
    }

    public function markAsLowcost(User $user)
    {
        $user->role_id = 3;
        $user->save();

        return redirect()->route('user.show', $user)->with('success', 'Usuario marcado como lowcost');
    }

    public function adjudicar(Request $request, $auction_id)
    {
        //SOLO SE PUEDE ADJUDICAR SI LA SUBASTA YA SOBREPASÓ EL END_DATE
        //HAY QUE EVALUAR QUE EL USUARIO GANADOR DE LA SUBASTA TODAVÍA TENGA CREDITOS DISPONIBLES
        //EN EL CADO DE QUE NO, HAY QUE ADJUDICARLE A LA SEGUNDA PUJA GANADORA SI ES QUE EXISTE

        //ME TRAIGO LA SUBASTA
        $auction = Auction::find($auction_id);
        $now = Carbon::now();

        //ME TRAIGO LA MEJOR PUJA LA CUAL POSEE EL USUARIO GANADOR
        $bestBid = AuctionUser::where('auction_id', $auction_id)->where('best_bid', true)->first();

        //ME TRAIGO EL USUARIO
        $user = User::find($bestBid->user_id);

        //SI EL USUARIO GANADOR NO ES VÁLIDO PARA ADJUDICARLO GANADOR
        if (!$user->validUser($auction->week)) {
            //CREO UNA COLLECCION CON TODOS LOS POSIBLES GANADORES
            $orderedBidsCollection = $auction->biddersByLatest();

            //LLAMO A CHOOSEVALIDUSER QUE SE ENCARGA DE RECORRER Y ELEGIR UN USUARIO VÁLIDO
            $user = $this->chooseValidUser($orderedBidsCollection, $auction->week);

            if ($user == 'sin usuarios válidos') {
                return redirect()->back()->with('error', 'No hay usuarios válidos para esta subasta, por favor elimine la subasta.');
            }
        }

        $auction->winner_id = $user->id;
        $auction->save();

        $user->available_weeks = $user->available_weeks - 1;
        $user->save();

        return redirect()->route('auction.show', ['id' => $auction_id])->with('success', 'Subasta adjudicada.');
    }

    public function chooseValidUser($bids, $date)
    {
        //SI POR ALGUNA RAZÓN EL USUARIO CON LA PUJA GANADORA NO ESTÁ DISPONIBLE, EVALUO LA SIGUIENTE MEJOR PUJA
        foreach ($bids as $bid) {
            $user = User::find($bid->user_id);
            if ($user->validUser($date)) {
                return $user;
            }
        }
        return 'sin usuarios válidos';
    }

    public function testFunction()
    {
        $date = "2019-06-19";
        $user = Auth::user();
        dd($user->ValidUser($date));
    }

}


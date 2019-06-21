<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\AuctionUser;
use App\Auction;
use App\User;
use Auth;

class UserController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $premiumUsers = User::where('role_id', 2)->get();
        $lowcostUsers = User::where('role_id', 3)->get();
        $cardUsers    = User::where('card_verification', false)->where('role_id', '!=', 1)->where('card_number', '!=', null)->get();
        return view('user.index')->with('premiumUsers', $premiumUsers)->with('lowcostUsers', $lowcostUsers)->with('cardUsers', $cardUsers);
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
    public function show(User $user)
    {
        //  return view('user.show')->with('user', $user)->with('hotsales', $user->hotsales())->with('auctions', $user->auctions())->with('reservations', $user->reservations());
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit()
    {

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
    public function destroy(User $user)
    {
        $user->delete();
        return redirect()->route('/');
    }

    public function pujar(Request $request, $auctionId)
    {
        //--------------------------------------
        //EL USUARIO NO PODRÁ PUJAR SI:
        //  SU NÚMERO DE TARJETA NO ESTÁ CONFIRMADO -> VALIDADO POR MIDDLEWARE
        //  EL VALOR DE LA PUJA ES MENOR A LA PUJA PREVIA
        //  LA PUJA PREVIA PERTENECE AL USUARIO
        $rules = [
            'bid_value' => 'required|numeric'
        ];

        $customMessages = [
            'bid_value.required' => 'El valor de la puja es requerido',
            'bid_value.numeric'  => 'El valor debe ser numerico',
        ];

        $this->validate($request, $rules, $customMessages);

        $user = Auth::user();
        if (!$user->hasValidCard()) {
            return redirect()->back()->with('error', 'Usted no poseé una numero de tarjeta validado');
        }

        //ME TRAIGO TODAS LAS PUJAS DE LA SUBASTA
        $bids = AuctionUser::where('auction_id', $auctionId);
        $auction = Auction::find($auctionId);
        if($bids->count() > 0){ //ME TRAIGO LA MEJOR PUJA
            $previousBid = AuctionUser::where('auction_id', $auction->id)->where('best_bid', true)->get()->first();

            if ($previousBid->user_id == Auth::user()->id) {//SI LA MEJOR PUJA ES DEL USUARIO NO LO DEJO PUJAR
                return redirect()->back()->with('error', 'Usted ya tiene la puja ganadora en la subasta.');
            }

            if ($request->bid_value <= $auction->best_bid_value) {//SI EL VALOR DE LA PUJA ES MENOR AL DE LA GANADORA NO LO DEJO PUJAR
                return redirect()->back()->with('error', 'El valor de la puja debe ser mayor al valor de la puja vigente.');
            }

            //Si pasó todas las validaciones significa que la puja se va a guardar, entonces a la puja anterior se le pone el campo 'best_bid' en false
            $previousBid->best_bid = false;
            $previousBid->save();

        }

        //Esta es la nueva puja
        $bid = new AuctionUser;

        $bid->user_id = $user->id;
        $bid->auction_id = $auction->id;
        $bid->value = $request->bid_value;

        //Se actualiza el valor de la mayor puja de la subasta
        $auction->best_bid_value = $request->bid_value;
        $auction->update();

        $bid->save();

        return redirect()->route('auction.show', ['id' => $auctionId])->with('success', 'Puja registrada!');
    }

    public function reserveHome(Home $home, $date)
    {
        $user = Auth::user();

        if (!$user->hasAvailableWeek()) {
            return redirect()->back()->with('error', 'Ustéd no poseé creditos disponibles');
        }
        if (!$user->isPremium()) {
            return redirect()->back()->with('error', 'Ustéd no es un usuario Premium');
        }
        if ($home->isOccupied($date)) {
            return redirect()->back()->with('error', 'La residencia no se encuentra disponible para esta semana');
        }

        $reservation = new HomeUser;

        $reservation->user_id = $user->id;
        $reservation->home_id = $home->id;
        $reservation->week = $date;

        $reservation->save();

        $user->available_weeks = $user->available_weeks - 1;

        $user->save();

        return redirect()->route('show', $home)->with('success', 'La reserva ha sido registrada');

        //FALTARIA ELIMINAR CUALQUIER PUJA QUE EL USUARIO TENGA PARA LA SEMANA DE LA RESERVA
    }

    public function reserveHotsale(Hotsale $hotsale, $date)
    {
        $user = Auth::user();

        if (!$user->hasAvailableWeek()) {
            return redirect()->back()->with('error', 'Ustéd no poseé creditos disponibles');
        }
        if (!$user->isPremium()) {
            return redirect()->back()->with('error', 'Ustéd no es un usuario Premium');
        }
        if ($home->isOccupied($date)) {
            return redirect()->back()->with('error', 'La residencia no se encuentra disponible para esta semana');
        }

        $hotsale->user_id = $user->id;
        $hotsale->save();

        $user->available_weeks = $user->available_weeks - 1;

        $user->save();

        return redirect()->route('hotsale.show', $hotsale)->with('success', 'La reserva ha sido registrada');

        //FALTARIA ELIMINAR CUALQUIER PUJA QUE EL USUARIO TENGA PARA LA SEMANA DE LA RESERVA
    }

}

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
        $user = User::all(); 
        return $user;
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

    public function pujar(Request $request, $auctionId)
    {
        //--------------------------------------
        //EL USUARIO NO PODRÁ PUJAR SI:
        //  SU NÚMERO DE TARJETA NO ESTÁ CONFIRMADO -> VALIDADO POR MIDDLEWARE
        //  EL VALOR DE LA PUJA ES MENOR A LA PUJA PREVIA
        //  LA PUJA PREVIA PERTENECE AL USUARIO


        $bids = AuctionUser::where('auction_id', $auctionId);
        $auction = Auction::find($auctionId);
        if($bids->count() > 0){
            $previousBid = AuctionUser::where('auction_id', $auction->id)->where('best_bid', true)->get()->first();

            if ($previousBid->user_id == Auth::user()->id) {
                return redirect()->back()->with('error', 'Usted ya tiene la puja ganadora en la subasta.');        
            }

            if ($request->bid_value <= $auction->best_bid_value) {
                return redirect()->back()->with('error', 'El valor de la puja debe ser mayor al valor de la puja vigente.');        
            }

            //Si pasó todas las validaciones significa que la puja se va a guardar, entonces a la puja anterior se le pone el campo 'best_bid' en false
            $previousBid->best_bid = false;
            $previousBid->save();

        }

        //Esta es la nueva puja
        $bid = new AuctionUser;

        $bid->user_id = Auth::user()->id;
        $bid->auction_id = $auction->id;
        $bid->value = $request->bid_value;
    
        //Se actualiza el valor de la mayor puja de la subasta
        $auction->best_bid_value = $request->bid_value;
        $auction->update();

        $bid->save();

        return redirect()->route('auction.show', ['id' => $auctionId])->with('success', 'Puja registrada!');
    }

}

<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\User;

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
        $previousBid = AuctionUser::where('id', $auctionId)->where('best_bid', true);

        if ($request->value <= $previousBid->value) {
            return redirect()->back()->with('error', 'El valor de la puja debe ser mayor al valor de la puja vigente.');        
        }
        if ($request->user_id == Auth::user()->id) {
            return redirect()->back()->with('error', 'Ustéd ya tiene una puja ganadora en la subasta.');        
        }
        //--------------------------------------

        $bid = new AuctionUser;

        $bid->user_id = Auth::user()->id;
        $bid->auction_id = $auctionId;
        $bid->value = $request->value;

        $bid->save();

        //Ya que esta va a ser la nueva puja más alta debemos buscar la anterior puja y poner el campo 'best_bid' en false

        $previousBid->best_bid = false;
        $previousBid->save();

        return redirect()->route('auction.show', ['id' => $auctionId])->with('success', 'Puja registrada');


    }

}

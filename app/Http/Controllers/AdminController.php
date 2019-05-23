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

    public function adjudicar(Request $request)
    {
        //SOLO SE PUEDE ADJUDICAR SI LA SUBASTA YA SOBREPASÓ EL END_DATE
        $auctionId = $request->route()->parameter('id');
        $auction = Auction::find($auctionId);
        $now = Carbon::now();
        
        if (!($now > $auction->end_date)) {
            return redirect()->back()->with('error', 'La subasta todavia no ha finalizado');
        }

        $bestBid = AuctionUser::where('auction_id', $auctionId)->where('best_bid', true)->first();

        $auction->winner_id = $bestBid->user_id;
        $auction->save();

        return redirect()->route('auction.show', ['id' => $auctionId])->with('success', 'Subasta adjudicada.');
    }
}

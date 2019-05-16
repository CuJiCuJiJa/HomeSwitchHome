<?php
namespace App\Http\Controllers;
use Illuminate\Http\Request;
use App\Auction;

class AuctionController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    
    public function index()
    {
        $auctions = Auction::all();
        return view('auction.index', compact('auctions'));
    }
    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    
    public function create()
    {
        return view('auction.create');
    }
    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    
    public function store(Request $request)
    {
        $data                   = $request->all();
        $auction                = new Auction;
        $auction->starting_date = $request->starting_date;
        $auction->week          = $request->week;
        $auction->year          = $request->year;
        $auction->base_price    = $request->base_price;
        $auction->home_id       = 1;//$request->home_id; esta hardcodeado 1 porque es el id de la unica residencia que tenia cargada.
        //dd($auction);
        $auction->save();
        return redirect()->route('show', ['id' => $auction->id])->with('success', 'Subasta creada');
    }
    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    
    public function show($id)
    {
        $auction = Auction::find($id);
        return view('auction.show')->with('auction', $auction);
    }
    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    
    public function edit($id)
    {
        return view('auction.edit');
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
        $data = $request->all();
        $auction = Auction::find($id);
        $auction->startingDate = $request->startingDate;
        $auction->week         = $request->week;
        $auction->year         = $request->year;
        $auction->base_price   = $request->base_price;
        $auction->home_id      = $request->home_id;
        $auction->save();
        return redirect()->route('show', ['id' => $auction->id])->with('success', 'Subasta modificada');
    }
    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    
    public function destroy($id)
    {
        $auction = Auction::find($id);
        $auction->delete();
        return redirect()->route('index')->with('success', 'Subasta eliminada');
    }

}
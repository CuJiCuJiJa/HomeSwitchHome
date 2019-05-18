<?php
namespace App\Http\Controllers;
use Illuminate\Http\Request;
use App\Auction;
use App\Home;
use Carbon\Carbon;

class AuctionController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    
    public function index()
    {
        $activeAuctions = Auction::all();
        $trashedAuctions = Auction::withTrashed();

        return view('auction.index')->with('activeAuctions', $activeAuctions)->with('trashedAuctions', $trashedAuctions);
    }

    public function listActives()
    {
        $auctions = Auction::all();
        return view('auction.list')->with('auctions', $auctions);
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
        //La residencia debe estar disponible para la semana de reserva elegida.
        //La semana de reserva será 6 meses después del fin de la subasta.
        //No puede existir más de una subasta para la misma residencia en la misma semana.
        $home = Auction::where('home_id', $request->home_id)->where('starting_date', $request->starting_date);

        if ($home->count() > 0){
            return redirect()->back()->with('error', 'La residencia seleccionada no está disponible para la semana elegida');
        }
        //calculo la semana para la cual la residencia será ocupada
        $week = Carbon::parse($request->starting_date);
        $week->addMonths(6);

        $auction = new Auction;
        $auction->starting_date = $request->starting_date;
        $auction->week = $week;
        $auction->year = $request->year;
        $auction->base_price = $request->base_price;
        $auction->home_id = 1;//$request->home_id; esta hardcodeado 1 porque es el id de la unica residencia que tenia cargada.
    
        $auction->save();
        return redirect()->route('auction.show', ['id' => $auction->id])->with('success', 'Subasta creada!');
    }
    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    
    public function show(Auction $auction)
    {
        return view('auction.show')->with('auction', $auction);
    }
    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    
    public function edit(Auction $auction)
    {
        //Si la subasta ya ha iniciado no se puede modificar
        $now = Carbon::now();
        if ($auction->startingDate > $now) {
            return redirect()->back()->with('error', 'La subasta ya ha iniciado y no esposible modificarla');
        }

        return view('auction.edit');
    }
    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    
    public function update(Request $request, Auction $auction)
    {
        //NO SE CUALES CAMPOS QUE SE PUEDEN MODIFICAR
        $auction->base_price   = $request->base_price;
    
        $auction->save();
        return redirect()->route('auction.show', ['id' => $auction->id])->with('success', 'Subasta modificada!');
    }
    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    
    public function destroy(Auction $auction)
    {
        if ($auction->bids) {
            return redirect()->back()->with('error', 'La subasta posee pujas, por lo tanto no es posible eliminarla');
        }
        $auction->delete();
        return redirect()->route('index')->with('success', 'Subasta eliminada!');
    }

}
<?php
namespace App\Http\Controllers;
use Illuminate\Http\Request;
use App\Auction;
use App\Home;
use Carbon\Carbon;
use Illuminate\Support\Facades\Input;
use Auth;
use App\User;

class AuctionController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
   /*  public function __construct()
    {
        $this->middleware('checkAuction')->only('show');
    } */

     public function index()
    {
        $user = Auth::user();
        $now = Carbon::now()->toDateString();
        $pendingAuctions = Auction::where('active', false)->where('winner_id', null)->where('best_bid_value', '!=', 0 )->get();
        $indexAuctions = Auction::all()->where('active', true);
        $activeAuctions = Auction::all()->where('active', true); //Recupero subastas activas
        $a = Auction::where('active', false)->get();
        $b = Auction::where('winner_id', '!=' , null)->orWhere('end_date','>', $now )->get();
        $c = $a->intersect(  (Auction::where('best_bid_value', '=' , 0 )->get())->intersect(Auction::where('end_date','<', $now )->get()));
        $inactiveAuctions = ($a->intersect($b))->union($c);
        $trashedAuctions = Auction::onlyTrashed()->get();  //Recupero subastas eliminadas
        $cantAuctions = $activeAuctions->count() + $trashedAuctions->count();

        if ((!$user->isAdmin())) {        //Si el usuario NO es administrador no quiero todas las activas o eliminadas sino esas en las que participe

            $trashedAuctions = Auction::all()->where('active', false); //ACA GUARDO LAS SUBASTAS INACTIVAS, PERO LA VARIABLE SE LLAMA TRASHED PARA MATCHEAR EL DEL RETURN

            $myBidsAuctionId = $user->auctions->unique(['auction_id']); //Recupero los id de las subastas en las que participe
            $myAuctions = collect();

            foreach ($myBidsAuctionId as $i) {

                $auction = Auction::find($i->auction_id); //Recupero la subasta con los id que recupere arriba
                $myAuctions->push($auction);  // Las guardo en myAuctions

            }
            $activeAuctions = $activeAuctions->toBase()->intersect($myAuctions); //Separo las activas de entre las que participe
            $trashedAuctions = $trashedAuctions->toBase()->intersect($myAuctions); // separo las inactivas de entre las que participe
            $cantAuctions = $activeAuctions->count() + $trashedAuctions->count();
        }

        return view('auction.index')->with('activeAuctions', $activeAuctions)->with('trashedAuctions', $trashedAuctions)->with('cantAuctions', $cantAuctions)->with('indexAuctions', $indexAuctions)->with('pendingAuctions', $pendingAuctions)->with('inactiveAuctions', $inactiveAuctions);

    }

    public function listActives()
    {
        $auctions = Auction::paginate(10);
        return view('auction.list')->with('auctions', $auctions);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */

    public function create()
    {

       if (!Auth::user()->isAdmin()) {
          return redirect()->back();
      }
        $activeHomes = Home::where('active', TRUE)->get();
        return view('auction.create')->with('activeHomes', $activeHomes);

    }
    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */

    public function store(Request $request)
    {
        //Validación
        $now = Carbon::now()->toDateString();

        $rules = [
            'base_price'    => 'required|numeric',
            'home_id'       => 'required|numeric',
            'weekAuctioned' => 'required|after:today'
        ];

        $customMessages = [
            'weekAuctioned.required' => 'Debe seleccionar la semana a subastar',
            'weekAuctioned.after'    => 'La fecha debe ser posterior a la actual',
            'base_price.required'    => 'Debe ingresar un :attribute',
            'base_price.numeric'     => 'El :attribute debe ser un número',
            'home_id.required'       => 'Debe seleccionar la :attribute a ocupar'
        ];

        $this->validate($request, $rules, $customMessages);
        $weekAuctioned = Carbon::parse($request->weekAuctioned)->startOfWeek();;
        //La residencia debe estar disponible para la semana de reserva elegida.
        //La semana de reserva será 6 meses después del inicio de la subasta.
        //No puede existir más de una subasta para la misma residencia en la misma semana.
        $home = Auction::where('home_id', $request->home_id)->where('week', $weekAuctioned);
        //FALTA VALIDAR SI ESTÁ RESERVADA POR UN USUARIO

        if ($home->count() == 1){
            Input::flash();
            return redirect()->back()->with('sameAuction', 'La residencia seleccionada no está disponible para la semana elegida');
        }

        $end_date = Carbon::parse($request->starting_date)->addHours(72)->toDateString();
        $starting_date = Carbon::parse($request->starting_date)->toDateString();
        //Almacenamiento
        $auction                = new Auction;
        $auction->starting_date = $starting_date;
        $auction->end_date      = $end_date;
        $auction->week          = $weekAuctioned;
        $auction->base_price    = $request->base_price;
        $auction->home_id       = $request->home_id;

        if ($starting_date <= $now && $end_date >= $now) {
            $auction->active = true;
        }

        $auction->save();

        //Redirección
        return redirect()->route('auction.show', ['id' => $auction->id])->with('success', '¡Subasta creada con éxito!');
    }
    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */

    public function show(Auction $auction)
    {
        if ($auction->winner_id != null) {
            $winner = User::find($auction->winner_id);
        }
        else{
            $winner = null;
        }
        $bids = $auction->bids;
        $bids = $bids->sortByDesc(function($bid){
            return $bid->value;
        });

        return view('auction.show')->with('auction', $auction)->with('winner', $winner)->with('bids', $bids);
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
            return redirect()->back()->with('error', 'La subasta ya ha iniciado y no es posible modificarla');
        }
        $activeHomes = Home::where('active', true)->get();
        return view('auction.edit')->with('auction', $auction)->with('activeHomes', $activeHomes);
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
        //Validación
        $rules = [
            'base_price'    => 'required|numeric|digits_between:1,8',
        ];

        $customMessages = [
            'weekAuctioned.required' => 'Debe ingresar una semana',
            'base_price.required'    => 'Debe ingresar un :attribute',
            'base_price.numeric'     => 'El :attribute debe ser un número',
            'base_price.digitis_between'         => 'El :attribute debe tener menos de 8 digitos',
            'home_id.required'       => 'Debe seleccionar la :attribute a ocupar'

        ];

        $this->validate($request, $rules, $customMessages);
        $weekAuctioned = Carbon::parse($request->weekAuctioned)->startOfWeek();

        //La residencia debe estar disponible para la semana de reserva elegida.
        //La semana de reserva será 6 meses después del fin de la subasta.
        //No puede existir más de una subasta para la misma residencia en la misma semana.
        $home = Auction::where('home_id', $request->home_id)->where('id', '!=', $auction->id)->where('week', $weekAuctioned);

        if ($home->count() > 0){
            Input::flash();
            return redirect()->back()->with('sameAuction', 'La residencia seleccionada no está disponible para la semana elegida');
        }

        //Actualización
        $auction->base_price    = $request->base_price;
        $auction->save();

        //Redirección
        return redirect()->route('auction.show', ['id' => $auction->id])->with('success', '¡Subasta modificada con exito!');
    }
    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */

    public function destroy(Auction $auction)
    {
        /*if ($auction->bids) {
            return redirect()->back()->with('error', 'La subasta posee pujas, por lo tanto no es posible eliminarla');
        }*/
        if ($auction->winner_id != null) {
            return redirect()->route('auction.index')->with('error', 'La subasta ya ha sido adjudicada');
        }
        $auction->delete();
        return redirect()->route('auction.index')->with('success', '¡Subasta eliminada correctamente!');
    }

}

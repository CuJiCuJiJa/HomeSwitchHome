<?php
namespace App\Http\Controllers;
use Illuminate\Http\Request;
use App\Auction;
use App\Home;
use Carbon\Carbon;
use Illuminate\Support\Facades\Input;

class AuctionController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    
    public function index()
    {
        $activeAuctions  = Auction::all();          //Recupero subastas activas
        $trashedAuctions = Auction::withTrashed();  //Recupero subastas eliminadas
        $cantAuctions    = $activeAuctions->count();

        return view('auction.index')->with('activeAuctions', $activeAuctions)->with('trashedAuctions', $trashedAuctions)->with('cantAuctions', $cantAuctions);
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
        $activeHomes = Home::all();
        return view('auction.create')->with('activeHomes', $activeHomes);
        
    }
    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    
    public function store(Request $request)
    {  dd($request);
        //Validación
        $rules = [
            'starting_date' => 'required|date|after:today',
            'base_price'    => 'required|numeric',
            'home_id'       => 'required|numeric'
        ];

        $customMessages = [
            'starting_date.required' => 'Debe ingresar una :attribute para la subasta',
            'starting_date.after'    => 'La :attribute debe ser mayor a la fecha actual',
            'base_price.required'    => 'Debe ingresar un :attribute',
            'base_price.numeric'     => 'El :attribute debe ser un número',  
            'home_id.required'       => 'Debe seleccionar la :attribute a ocupar'
        ];

        $this->validate($request, $rules, $customMessages);

        //Calculo la semana para la cual la residencia será ocupada
        $week = Carbon::parse($request->starting_date);
        $week->addDays(3);      //Se le suman 3 días a la fecha de inicio para obtener la fecha de fin
        $week->addMonths(6);    //Se le suman 6 meses a la fecha de fin para obtener la semana a ocupar
        $week->startOfWeek();   //Se obtiene el lunes en el que comienza la semana de ocupación.

        //La residencia debe estar disponible para la semana de reserva elegida.
        //La semana de reserva será 6 meses después del fin de la subasta.
        //No puede existir más de una subasta para la misma residencia en la misma semana.
        $home = Auction::where('home_id', $request->home_id)->where('week', $week);

        if ($home->count() > 0){
            Input::flash();
            return redirect()->back()->with('sameAuction', 'La residencia seleccionada no está disponible para la semana elegida');
        }

        //Almacenamiento
        $auction                = new Auction;
        $auction->starting_date = $request->starting_date;
        $auction->week          = $week;
        $auction->base_price    = $request->base_price;
        $auction->home_id       = $request->home_id;
        $auction->save();

        //Redirección
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
            return redirect()->back()->with('error', 'La subasta ya ha iniciado y no es posible modificarla');
        }
        $activeHomes = Home::all();
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
            'starting_date' => 'required|date|after:today',
            'base_price'    => 'required|numeric',
            'home_id'       => 'required|numeric'
        ];

        $customMessages = [
            'starting_date.required' => 'Debe ingresar una :attribute para la subasta',
            'starting_date.after'    => 'La :attribute debe ser mayor a la fecha actual',
            'base_price.required'    => 'Debe ingresar un :attribute',
            'base_price.numeric'     => 'El :attribute debe ser un número',  
            'home_id.required'       => 'Debe seleccionar la :attribute a ocupar'
        ];

        $this->validate($request, $rules, $customMessages);

        //Calculo la semana para la cual la residencia será ocupada
        $week = Carbon::parse($request->starting_date);
        $week->addDays(3);      //Se le suman 3 días a la fecha de inicio para obtener la fecha de fin
        $week->addMonths(6);    //Se le suman 6 meses a la fecha de fin para obtener la semana a ocupar
        $week->startOfWeek();   //Se obtiene el lunes en el que comienza la semana de ocupación.

        //La residencia debe estar disponible para la semana de reserva elegida.
        //La semana de reserva será 6 meses después del fin de la subasta.
        //No puede existir más de una subasta para la misma residencia en la misma semana.
        $home = Auction::where('home_id', $request->home_id)->where('week', $week);

        if ($home->count() > 0){
            Input::flash();
            return redirect()->back()->with('sameAuction', 'La residencia seleccionada no está disponible para la semana elegida');
        }

        //Actualización
        $auction->starting_date = $request->starting_date;
        $auction->week          = $week;
        $auction->base_price    = $request->base_price;
        $auction->home_id       = $request->home_id;
        $auction->save();

        //Redirección
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
        /*if ($auction->bids) {
            return redirect()->back()->with('error', 'La subasta posee pujas, por lo tanto no es posible eliminarla');
        }*/
        $auction->delete();
        return redirect()->route('auction.index')->with('success', 'Subasta eliminada!');
    }

}
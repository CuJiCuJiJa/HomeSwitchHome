<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Home;
use Carbon\Carbon;
use Auth;
use App\User;

class HomeController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $trashedHomes = Home::onlyTrashed()->get();
        $activeHomes  = Home::where('active', true)->get();
        $cantHomes    = $activeHomes->count();

        return view('home.index')->with('activeHomes', $activeHomes)->with('cantHomes', $cantHomes)->with('trashedHomes', $trashedHomes);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('home.create');
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
        $rules = [ 'location' => 'required|max:100' ];

        $customMessages = [ 'location.required' => 'Debe ingresar la ubicación de la residencia' ];

        $this->validate($request, $rules, $customMessages);

        //Almacenamiento
        $home           = new Home;
        $home->location = $request->location;
        $home->descrip  = $request->descrip;
        $home->save();

        //Redirección
        return redirect()->route('home.show', ['id' => $home->id])->with('success', '¡Residencia creada con éxito!');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show(Home $home)
    {
        return view('home.show', compact('home'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit(Home $home)
    {
        return view('home.edit', compact('home'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Home $home)
    {
        //Validación
        $rules = [ 'location' => 'required|max:100' ];

        $customMessages = [ 'location.required' => 'Debe ingresar la ubicación de la residencia' ];

        $this->validate($request, $rules, $customMessages);

        //Almacenamiento
        $home->location = $request->location;
        $home->descrip  = $request->descrip;
        $home->save();

        //Redirección
        return redirect()->route('home.show', ['id' => $home->id])->with('success', '¡Residencia ha sido actualizada!');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    /* public function destroy(Home $home)
    {
        if ($home->hasActiveHotsales()) {
            return redirect()->back()->with('error', 'No es posible eliminar la residencia, por que hay hotsales activos');
        }

        $home->delete();
        return redirect('home')->with('success', '¡La residencia ha sido borrada!');
    } */

    public function restore($id)
    {
        $home = Home::withTrashed()->find($id)->restore();
        return redirect()->route('home.index')->with('success', 'Residencia restaurada');
    }

    public function anular($homeId)
    {
        $home = Home::find($homeId);                            //Obtengo la residencia
        $now = Carbon::now();                                   //Obtengo el día de hoy

        //Valido que la residencia no tenga reservas para las cuales falten menos de 6 meses

        $reservations = $home->reservations;                    //Obtengo todas las reservas de esa residencia
        foreach ($reservations as $reservation) {               //Por cada una de las reservas...
            $week = Carbon::parse($reservation->week);          //Obtengo la semana de la reserva
            if ($now > $week->subMonths(6) ) {                  //Si faltan menos de 6 meses para la reserva...
                $user = User::find($reservation->user_id);      //Obtengo el usuario de la reserva actual
                return redirect()->route('home.index')->with('error', 'La residencia no puede ser eliminada ya que faltan menos de 6 meses para la reserva del '.$reservation->week.', perteneciente al usuario '.$user->name.' (Email: '.$user->email.')');
            }
        }

        $auctions = $home->auctions;                            //Obtengo todas las subastas con esa residencia
        foreach ($auctions as $auction) {                       //Por cada una de las subastas...
            if ($auction->winner_id != null) {                  //Si tiene ganador...
                $user = User::find($auction->winner_id);        //Obtengo el usuario de la subasta adjudicada
                return redirect()->route('home.index')->with('error', 'La residencia no puede ser eliminada, faltan menos de 6 meses para la semana ('.$auction->week.'), perteneciente al usuario '.$user->name.' (Email: '.$user->email.')');
            }else{
                if($now >= $auction->starting_date){
                    return redirect()->route('home.index')->with('error', 'La residencia no puede ser eliminada ya que está asociada a una subasta activa.');
                }
            }
        }

        //Como pasó las validaciones, tengo que borrar las reservas para las que falten mas de 6 meses, y las subastas que aún no hayan iniciado.

       // dd("LE CHUPÓ TODO UN HUEVO EN LINEA 153");

       /* foreach ($auctions as $auction) {
            $auction->delete();
        }*/

        $home->active = false;
        $home->save();
        return redirect()->route('home.index')->with('success', '¡La residencia ha sido anulada!');
    }

    public function changePassword(Request $request){

        if (!(\Hash::check($request->get('current-password'), Auth::user()->password))) {
            // The passwords matches
            return redirect()->back()->with("error","Your current password does not matches with the password you provided. Please try again.");
        }

        if(strcmp($request->get('current-password'), $request->get('new-password')) == 0){
            //Current password and new password are same
            return redirect()->back()->with("error","New Password cannot be same as your current password. Please choose a different password.");
        }

        $validatedData = $request->validate([
            'current-password' => 'required',
            'new-password' => 'required|string|min:6|confirmed',
        ]);

        //Change Password
        $user = Auth::user();
        $user->password = bcrypt($request->get('new-password'));
        $user->save();

        return redirect()->back()->with("success","Password changed successfully !");

    }

    public function getchangePassword(){
        return view('user.changePassword');
    }

}

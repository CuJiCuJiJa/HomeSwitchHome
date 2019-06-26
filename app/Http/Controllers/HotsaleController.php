<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Input;
use Illuminate\Http\Request;
use App\Hotsale;
use App\Home;
use App\User;
use App\HotsaleUser;
use Carbon\Carbon;
use Auth;

class HotsaleController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */

    public function index()
    {
        $activeHotsales = Hotsale::where('user_id', null)->get();
        $reservedHotsales = Hotsale::where('user_id', '!=', null)->get();
        $trashedHotsales = Hotsale::onlyTrashed()->get();
        return view('hotsale.index')->with('activeHotsales', $activeHotsales)->with('reservedHotsales', $reservedHotsales)->with('trashedHotsales', $trashedHotsales);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        if(!Auth::user()->isAdmin()){
            return redirect()->back();
        }else{
            $activeHomes = Home::where('active', TRUE)->get();
            return view('hotsale.create')->with('activeHomes', $activeHomes);
        }
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
        $rules = [
            'weekOffered' => 'required',
            'price'       => 'required|numeric',
            'home_id'     => 'required|numeric'
        ];

        $customMessages = [
            'weekOffered.required' => 'Debe seleccionar la semana a ofertar',
            'price.required'       => 'Debe ingresar el precio del Hotsale',
            'price.numeric'        => 'El precio del Hotsale debe ser un valor en $',
            'home_id.required'     => 'Debe seleccionar la :attribute a ocupar'
        ];

        $this->validate($request, $rules, $customMessages);
        $home = Home::find($request->home_id);
        if($home->scopeIsOccupied($home, $request->weekOffered)){
            Input::flash();
            return redirect()->back()->with('isOccupied', 'La residencia seleccionada no está disponible para la semana elegida');
        }

        $week = Carbon::parse($request->weekOffered);
        //Almacenamiento
        $hotsale          = new Hotsale;
        $hotsale->week    = $week;
        $hotsale->price   = $request->price;
        $hotsale->home_id = $request->home_id;

        $hotsale->save();

        //Redirección
        return redirect()->route('hotsale.show', ['id' => $home->id])->with('success', '¡Hotsale creado con éxito!');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show(Hotsale $hotsale)
    {
        return view('hotsale.show')->with('hotsale', $hotsale);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit(Hotsale $hotsale)
    {
        return view('hotsale.edit')->with('hotsale', $hotsale);
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
    public function destroy(Hotsale $hotsale)
    {
        $hotsale->delete();
        return redirect()->route('index')->with('success', 'Hotsale eliminado');
    }
}

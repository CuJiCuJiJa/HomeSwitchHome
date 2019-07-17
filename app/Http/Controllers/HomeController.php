<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Home;

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
    public function destroy(Home $home)
    {
        /*if ($home->hasActiveHotsales()) {
            return redirect()->back()->with('error', 'No es posible eliminar la residencia, por que hay hotsales activos');
        }*/

        $home->delete();
        return redirect('home')->with('success', '¡La residencia ha sido borrada!');
    }

    public function restore($id)
    {
        $home = Home::withTrashed()->find($id)->restore();
        return redirect()->route('home.index')->with('success', 'Residencia restaurada');
    }

    public function anular($homeId)
    {
        $home = Home::find($homeId);
        $home->active = false;
        $home->save();
        return redirect()->route('home.index')->with('success', '¡La residencia ha sido anulada!');
    }
}

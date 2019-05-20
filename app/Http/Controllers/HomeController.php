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
        $activeHomes  = Home::all();
        $trashedHomes = Home::withTrashed();

        return view('home.index')->with('trashedHomes', $trashedHomes)->with('activeHomes', $activeHomes);
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
        $request->validate([
            'location' => 'required|max:100',
        ]);

        //Almacenamiento
        $home           = new Home;
        $home->location = $request->location;
        $home->descrip  = $request->descrip;
        $home->save();

        //Redirección
        return redirect()->route('home.show', ['id' => $home->id])->with('success', 'Residencia creada!');
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
        $request->validate([
            'location' => 'required|max:100',
        ]);

        //Almacenamiento
        $home->location = $request->location;
        $home->descrip  = $request->descrip;
        $home->save();

        //Redirección
        return redirect()->route('home.show', ['id' => $home->id])->with('success', 'Residencia actualizada!');
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
        return redirect('home')->with('success', 'La residencia ha sido anulada!');
    }
}

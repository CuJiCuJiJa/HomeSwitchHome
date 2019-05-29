<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Hotsale;
use App\User;
use App\HotsaleUser;
use Auth;
use Carbon\Carbon;
use App\Home;

class HotsaleController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */

    protected function validator(array $data)
    {
        return Validator::make($data, [
            'week' => 'required',
            'price' => 'required|nuerical',
        ]);
    }

    public function index()
    {
        $hotsales = Hotsale::all();
        return view('hotsale.show')->with('hotsales', $hotsales);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('hotsale.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request, Home $home)
    {
        if ($home->isOccupied()) {
            return redirect()->back()->with('error', 'La residencia no está disponible en esta semana');
        }
        $this->validator($request->all())->validate();

        $hotsale = new Hotsale;

        $hotsale->week = $request->week;
        $hotsale->price = $request->price;
        $hotsale->home_id = $home->id;
        $hotsale->user_id = null;

        $hotsale->save();

        return redirect()->route('show', $home)->with('success', 'Hotsale creado');
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

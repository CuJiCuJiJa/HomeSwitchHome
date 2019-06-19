<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Auth;
use App\HomeUser;
use App\User;
use App\Home;
use Carbon\Carbon;

class ReservationController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */

     public function index()
    {
        $trashedReservations = HomeUser::withTrashed();
        $activeReservations = HomeUser::all();
        return view('reservation.index')->with('activeReservations', $reservations)->with('trashedReservations', $trashedReservations);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create($home_id)
    {
        $home = Home::find($home_id);
        return view('reservation.create')->with('home', $home);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $user = Auth::user();
        $home = Home::find($request->home_id);
        $carbonWeek = Carbon::parse($request->weekToReserve)->startOfWeek(); 

        if ($user->isPremium() && $user->hasAvailableWeek() && !$home->isOccupied($carbonWeek)) {

            $reservation = new HomeUser;
            $reservation->home_id = $home->id;
            $reservation->user_id = $user->id;
            $reservation->week = $carbonWeek;

            $reservation->save();
            
            $user->available_weeks = $user->available_weeks-1;
            $user->save();

            return redirect()->route('home.show', $home)->with('reservation', $reservation)->with('success', 'Reserva realizada con exito');

        }
        else{
            if (!$user->hasAvailableWeek()) {
                return redirect()->back()->with('error', 'Ustéd ya há alcanzado el limite de semanas por año.');
            }

            if ($home->isOccupied($carbonWeek)) {
                return redirect()->back()->with('error', 'La semana seleccionada no esta disponible');
            }

            if (!$user->isPremium()) {
                return redirect()->back()->with('error', 'Ustéd no es un usuario premium, considere asociarse.');
            }
        }
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
    public function destroy(Home $home)
    {
        $reservation = HomeUser::where('home_id', $home->id)->firstOrFail();
        $user = Auth::user();

        if (Carbon::now() < $reservation->week->subMonths(2)) {

            $user->available_weeks = $user->available_weeks + 1;

            if ($user->available_weeks > 2) {
                $user->available_weeks = 2;
            }
        }
        $reservation->delete();

        return redirect()->route('home.show')->with('success','Reserva cancelada');

    }
}

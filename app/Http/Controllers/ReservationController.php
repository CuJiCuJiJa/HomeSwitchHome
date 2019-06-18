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
    public function store(Request $request, $home_id)
    {
        $user = Auth::user();
        if ($user->isPremium() && $user->hasAvailableWeeks()) {

            $reservation = new HomeUser;

            $carbonWeek = Carbon::parse($request->week);
            $reservation->home_id = $home_id;
            $reservation->user_id = $user->id;
            $reservation->week = $carbonWeek;

            $reservation->save();

            $user->availaible_weeks = $user->availaible_weeks + 1;

            return redirect()->route('home.show')->with('reservation', $reservation);

        }
        if (!$user->hasAvailableWeeks()) {
            return redirect()->back()->with('error', 'Ustéd ya há utilizado sus semanas de reserva.');
        }
        if (!$user->isPremium()) {
            return redirect()->back()->with('error', 'Ustéd no es un usuario premium, considere asociarse.');
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

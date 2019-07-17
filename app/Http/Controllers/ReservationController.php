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
        return view('reservation.index')->with('activeReservations', $activeReservations)->with('trashedReservations', $trashedReservations);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create($home_id, $week)
    {
        $home = Home::find($home_id);
        return view('reservation.create')->with('home', $home)->with('week', $week);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    /* public function store(Request $request)
    {

        $user = Auth::user();
        $home = Home::find($request->home_id);
        $carbonWeek = Carbon::parse($request->weekToReserve)->startOfWeek()->toDateString();

        if ($user->isPremium() && $user->hasAvailableWeek() && !$home->isOccupied($carbonWeek)) {

            $reservation = new HomeUser;
            $reservation->home_id = $home->id;
            $reservation->user_id = $user->id;
            $reservation->week = $carbonWeek;

            $reservation->save();

            $user->available_weeks = $user->available_weeks-1;
            $user->save();

            return view('reservation.show', $home)->with('reservation', $reservation)->with('success', 'Reserva realizada con exito');

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
    } */

    public function store(Request $request)
    {
        $user = Auth::user();
        $home = Home::find($request->home_id);
        $carbonWeek = Carbon::parse($request->weekToReserve)->startOfWeek()->toDateString();

        if (!$user->hasAvailableWeek()) {
            return redirect()->back()->with('error', 'Ustéd no poseé creditos disponibles');
        }
        if (!$user->isPremium()) {
            return redirect()->back()->with('error', 'Ustéd no es un usuario Premium');
        }
        if ($home->isOccupied($carbonWeek)) {
            return redirect()->back()->with('error', 'La residencia no se encuentra disponible para esta semana');
        }
        if ($user->hasReservation($carbonWeek) || $user->hasHotsale($carbonWeek) || $user->hasAuction($carbonWeek)) {
            return redirect()->back()->with('error', 'Usted ya poseé una reserva para la misma semana');
        }

        $reservation = new HomeUser;

        $reservation->user_id = $user->id;
        $reservation->home_id = $home->id;
        $reservation->week = $carbonWeek;

        $reservation->save();

        $user->available_weeks = $user->available_weeks - 1;
        $user->save();

        return redirect()->route('reservation.show', $reservation)->with('success', 'La reserva ha sido registrada');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $reservation = HomeUser::find($id);
        return view('reservation.show')->with('reservation', $reservation);
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
        $reservation = HomeUser::where('home_id', $home->id)->first();
        $user = Auth::user();
        $now = Carbon::now()->toDateString();

        if ($now < $reservation->week->subMonths(2)) {

            $user->available_weeks = $user->available_weeks + 1;

            if ($user->available_weeks > 2) {
                $user->available_weeks = 2;
            }
        }
        $reservation->delete();

        return redirect()->route('auction.index')->with('success','Reserva cancelada');

    }
}

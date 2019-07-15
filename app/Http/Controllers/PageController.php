<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Auth;
use App\Auction;
use Carbon\Carbon;
use App\User;

class PageController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        //  $this->middleware('auth');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index()
    {
        return view('page');
    }

    public function testFunction()
    {
        $date = '2019-12-16';
        dd($user->validUser($date));
    }

    public function showChangePasswordForm(){
        return view('auth.passwords.reset');
    }
}

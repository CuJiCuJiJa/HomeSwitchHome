@extends('layouts.app')

@section('content')

        <div class="flex-center position-ref full-height">
        <div class="content">
                <div class="title m-b-md">
                    Home Switch Home
                </div>
                <div class="links">
                    @auth                    
                        <a href="{{ route('auction.index') }}">Subastas</a>
                        <a href="{{ route('home.index') }}">Residencias</a>
                    @else
                        <a href="{{ route('register') }}">Register</a>
                        <a href="{{ route('login') }}">Login</a>
                    @endauth
                    </div>
              </div>
            </div>
        </div>
@endsection
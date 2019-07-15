@extends('layouts.app')

@section('content')


    <div class="flex-center position-ref full-height img-cambiante" >
        <div class="content">
                <div class="title m-b-md">
                <img src="{{ asset('HSH-Logo.svg')}}" width="80px">  Home Switch Home
                </div>
                <div class="links">
                    @auth                    
                        <a href="{{ route('auction.index') }}">Subastas</a>
                        <a href="{{ route('hotsale.index') }}">Hotsales</a>
                    @else
                        <a href="{{ route('register') }}">Registrarse</a>
                        <a href="{{ route('login') }}">Iniciar sesión</a>
                    @endauth
                    </div>
              </div>
            </div>
        </div>
@endsection

@section('footer')

@endsection
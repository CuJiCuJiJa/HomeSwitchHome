@extends('layouts.app')

@section('content')
<div class="container mask-white">

    <div class="row justify-content-center">

        <div class="col-12 text-md-center full-height">

            @if(session('success'))
                <div class="exito horizontal-list">   
                    {{ session('success') }}
                </div>
            @endif

            @if($cantHomes == 0)
                <h2>Oops! Aún no se ha cargado ninguna residencia.</h2>
            @else
                <div class="card">
                    <div class="card-header"> Residencias </div>
                    @if (session('status'))
                        <div class="alert alert-success" role="alert">
                            {{ session('status') }}
                        </div>
                    @endif
                    
                    @foreach ($activeHomes as $home)
                        <div class="card-body">
                           <div class="descripcion">
                                Descripción: {{ $home->descrip }}
                                <br>
                                Ubicación: {{ $home->location }}
                            </div>

                            <div class="links horizontal-list">    
                                <a href="{{ route('home.show', $home->id) }}">Ver más</a>
                                <a href="{{ route('home.edit', $home->id) }}">Editar</a>
                            </div>
                            <hr>
                        </div>
                    @endforeach
                </div>
            @endif
            <div class="links horizontal-list"> 
            @if (Auth::user()->isAdmin())
                <a class="link" href="{{ route('home.create') }}">Agregar Residencia</a>
            @endif
            </div>
        </div>
    </div>
</div>
@endsection

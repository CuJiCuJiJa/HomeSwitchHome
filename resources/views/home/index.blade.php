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


                <div class="card">
                    <div class="card-header"> Residencias </div>
                    @if (session('status'))
                        <div class="alert alert-success" role="alert">
                            {{ session('status') }}
                        </div>
                    @endif
                    <h1>Residencias Activas </h1>
                    @if ($activeHomes->count() == 0)
                        <h2>¡Oops! No tienes subastas...</h2>
                    @else
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
                    @endif
                    <h1>Residencias Desactivadas </h1>
                    @if ($trashedHomes->count() == 0)
                        <h2>¡Oops! No tienes subastas...</h2>
                    @else
                        @foreach ($trashedHomes as $home)
                            <div class="card-body">
                            <div class="descripcion">
                                    Descripción: {{ $home->descrip }}
                                    <br>
                                    Ubicación: {{ $home->location }}
                                </div>
                                <hr>
                            </div>
                        @endforeach
                    @endif
                </div>
            <div class="links horizontal-list">
            @if (Auth::user()->isAdmin())
                <a class="link" href="{{ route('home.create') }}">Agregar Residencia</a>
            @endif
            </div>
        </div>
    </div>
</div>
@endsection

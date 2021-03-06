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

            @if($cantAuctions == 0 && $indexAuctions->count() == 0 && $pendingAuctions->count() == 0 && $inactiveAuctions->count() == 0)
                <h2>¡Oops! No tienes subastas...</h2>
            @else

                <div class="card">
                    <div class="card-header">Subastas</div>

                        @if (session('status'))
                            <div class="alert alert-success" role="alert">
                                {{ session('status') }}
                            </div>
                        @endif

                        @if (!Auth::user()->isAdmin())
                            
                            @if($activeAuctions->count() == 0)
                            @endif
                            @if($activeAuctions->count() != 0)
                            <h1>Mis Subastas Activas </h1>
                            @foreach ($activeAuctions as $activeAuction)
                                <div class="card-body">
                                    <div class="descripcion">
                                        La subasta abrira el {{ $activeAuction->starting_date }} y cerrara 72hs mas tarde.
                                        <br>
                                        La semana subastada comienza el lunes {{ $activeAuction->week }}
                                        <br>
                                        Ubicación de la residencia: {{ $activeAuction->home->location }}
                                    </div>
                                    <div class="links horizontal-list">
                                        <a href="{{ route('auction.show', [$activeAuction->id]) }}">Ver más</a>
                                        @if (Auth::user()->isAdmin())
                                            <a href="{{ route('auction.edit', [$activeAuction->id]) }}">Editar</a>
                                        @endif
                                    </div>
                                    <hr>
                                </div>
                            @endforeach
                            @endif    
                        @endif
                        @if (!Auth::user()->isAdmin())
                            
                            @if($trashedAuctions->count() == 0)
                            @endif
                            @if($trashedAuctions->count() != 0)
                            <h1>Mis Subastas Finalizadas </h1>
                            @foreach ($trashedAuctions as $trashedAuction)
                                <div class="card-body">
                                    <div class="descripcion">
                                        La subasta abrira el {{ $trashedAuction->starting_date }} y cerrara 72hs mas tarde.
                                        <br>
                                        La semana subastada comienza el lunes {{ $trashedAuction->week }}
                                        <br>
                                        Ubicación de la residencia: {{ $trashedAuction->home->location }}
                                    </div>
                                    <div class="links horizontal-list">
                                        <a href="{{ route('auction.show', [$trashedAuction->id]) }}">Ver más</a>
                                    </div>

                                    <hr>
                                </div>
                            @endforeach
                            @endif    
                        @endif
                        
                        @if($indexAuctions->count() == 0)
                            <h2>¡Oops! No tienes subastas...</h2>
                        @endif
                        @if($indexAuctions->count() != 0)
                        <h1>Subastas Activas</h1>

                        @foreach ($indexAuctions as $indexAuction)

                            <div class="card-body">
                                <div class="descripcion">
                                    La subasta abrira el {{ $indexAuction->starting_date }} y cerrara 72hs mas tarde.
                                    <br>
                                    La semana subastada comienza el lunes {{ $indexAuction->week }}
                                    <br>
                                    Ubicación de la residencia: {{ $indexAuction->home->location }}
                                </div>
                                <div class="links horizontal-list">
                                    <a href="{{ route('auction.show', [$indexAuction->id]) }}">Ver más</a>
                                    @if (Auth::user()->isAdmin())
                                        <a href="{{ route('auction.edit', [$indexAuction->id]) }}">Editar</a>
                                    @endif

                                </div>
                                <hr>
                            </div>
                        @endforeach
                        @endif
                        @if (Auth::user()->isAdmin())

                            <h1>Subastas Inactivas</h1>

                            @if($inactiveAuctions->count() == 0)
                                <h2>¡Oops! No tienes subastas...</h2>
                            @endif
                            @foreach ($inactiveAuctions as $inactiveAuction)

                                <div class="card-body">
                                    <div class="descripcion">
                                        La subasta abrira el {{ $inactiveAuction->starting_date }} y cerrara 72hs mas tarde.
                                        <br>
                                        La semana subastada comienza el lunes {{ $inactiveAuction->week }}
                                        <br>
                                        Ubicación de la residencia: {{ $inactiveAuction->home->location }}
                                    </div>
                                    <div class="links horizontal-list">
                                        <a href="{{ route('auction.show', [$inactiveAuction->id]) }}">Ver más</a>
                                        @if (Auth::user()->isAdmin())
                                            <a href="{{ route('auction.edit', [$inactiveAuction->id]) }}">Editar</a>
                                        @endif

                                    </div>
                                    <hr>
                                </div>
                            @endforeach

                            <h1> Subastas con adjudicación pendiente </h1>
                            @if($pendingAuctions->count() == 0)
                            <h2>¡Oops! No tienes subastas...</h2>
                            @endif
                            @foreach ($pendingAuctions as $pendingAuction)
                                <div class="card-body">
                                    <div class="descripcion">
                                        La subasta abrira el {{ $pendingAuction->starting_date }} y cerrara 72hs mas tarde.
                                        <br>
                                        La semana subastada comienza el lunes {{ $pendingAuction->week }}
                                        <br>
                                        Ubicación de la residencia: {{ $pendingAuction->home->location }}
                                    </div>
                                <div class="links horizontal-list">
                                    <a href="{{ route('auction.show', $pendingAuction->id) }}">Ver más</a>
                                </div>
                                    <hr>
                                </div>
                        @endforeach
                        <h1> Subastas eliminadas </h1>
                        @foreach ($trashedAuctions as $trashedAuction)
                            <div class="card-body">
                                <div class="descripcion">
                                    La subasta abrira el {{ $trashedAuction->starting_date }} y cerrara 72hs mas tarde.
                                    <br>
                                    La semana subastada comienza el lunes {{ $trashedAuction->week }}
                                    <br>
                                    Ubicación de la residencia: {{ $trashedAuction->home->location }}
                                </div>
                                <div class="links horizontal-list">
                                    <a href="{{ route('auction.show', $trashedAuction->id) }}">Ver más</a>
                                </div>
                                <hr>
                            </div>
                        @endforeach
                    @endif
                </div>
            @endif
            <div class="links horizontal-list">
            @if (Auth::user()->isAdmin())
                <a href="{{ route('auction.create') }}">Agregar Subasta</a>
            @endif
                <a href="{{ route('getSearch.auction') }}">Buscar Subasta</a>
            </div>
        </div>
    </div>
</div>
@endsection



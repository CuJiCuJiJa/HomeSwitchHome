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

            @if($history['hotsales']->count() == 0)
                <h2>¡Oops! Ustéd no ha comprado ningún Hotsale...</h2>
            @else
                <div class="card">
                    <div class="card-header">Hotsales comprados</div>
                    @if (session('status'))
                        <div class="alert alert-success" role="alert">
                            {{ session('status') }}
                        </div>
                    @endif
                    @foreach ($history['hotsales'] as $hotsale)
                        <div class="card-body">
                            <div class="descripcion">
                                La semana ofertada comienza el lunes de la semana {{ $hotsale->week }}.
                                <br>
                                Ubicación de la residencia: {{ $hotsale->home->location }}.
                                <br>
                                Precio: ${{ $hotsale->price }}.
                                <br>
                            </div>
                            <div class="links horizontal-list">
                                <a href="{{ route('hotsale.show', [$hotsale->id]) }}">Ver más</a>
                            </div>
                            <hr>
                        </div>
                    @endforeach
                </div>
            @endif


            @if($history['auctions']->count() == 0)
                <h2>¡Oops! Ustéd no ha ganado ninguna subasta...</h2>
            @else
                <div class="card">
                    <div class="card-header">Subastas ganadas</div>
                    @if (session('status'))
                        <div class="alert alert-success" role="alert">
                            {{ session('status') }}
                        </div>
                    @endif
                    @foreach ($history['auctions'] as $auction)
                        <div class="card-body">
                            <div class="descripcion">
                                La semana comienza el lunes de la semana {{ $auction->week }}.
                                <br>
                                Ubicación de la residencia: {{ $auction->home->location }}.
                                <br>
                            </div>
                            <div class="links horizontal-list">
                                <a href="{{ route('auction.show', [$auction->id]) }}">Ver más</a>
                            </div>
                            <hr>
                        </div>
                    @endforeach
                </div>
            @endif
            <div class="card-header">Subastas activas en la que usted ha pujado</div>
            @if($history['auctionsWithBids']->count() == 0)
                <h2>¡Oops! Ustéd no posee pujas en subastas en curso...</h2>
            @else
                <div class="card">

                    @if (session('status'))
                        <div class="alert alert-success" role="alert">
                            {{ session('status') }}
                        </div>
                    @endif

                    @foreach ($history['auctionsWithBids'] as $auction)

                        <div class="card-body">
                            <div class="descripcion">
                                    La semana comienza el lunes de la semana {{ $auction->week }}.
                                    <br>
                                    Ubicación de la residencia: {{ $auction->home->location }}.
                                    <br>
                                <br>
                            </div>
                            <div class="links horizontal-list">
                                <a href="{{ route('auction.show', [$auction->id]) }}">Ver más</a>
                            </div>
                            <hr>
                        </div>
                    @endforeach
                </div>
            @endif


            @if($history['reservations']->count() == 0)
                <h2>¡Oops! Ustéd no ha reservado ninguna residencia...</h2>
            @else
                <div class="card">
                    <div class="card-header">Residencias Premium reservadas</div>
                    @if (session('status'))
                        <div class="alert alert-success" role="alert">
                            {{ session('status') }}
                        </div>
                    @endif
                    @foreach ($history['reservations'] as $reservation)
                        <div class="card-body">
                            <div class="descripcion">
                                La semana comienza el lunes de la semana {{ $reservation->week }}.
                                <br>
                                Ubicación de la residencia: {{ $reservation->home->location }}.
                                <br>
                            </div>
                            <div class="links horizontal-list">
                                <a href="{{ route('reservation.show', [$reservation->id]) }}">Ver más</a>
                            </div>
                            <hr>
                        </div>
                    @endforeach
                </div>
            @endif

        </div>
    </div>
</div>
@endsection

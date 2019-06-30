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

            @if($reservedHotsales->count() == 0 &&  $activeHotsales->count() == 0 && $trashedHotsales->count() == 0)
                <h2>¡Oops! No tienes hotsales...</h2>
            @else

                <div class="card">
                    <div class="card-header">Hotsales</div>

                        @if (session('status'))
                            <div class="alert alert-success" role="alert">
                                {{ session('status') }}
                            </div>
                        @endif

                        <h1>hotsales activos</h1>
                        @if($activeHotsales->count() == 0)
                            <h2>¡Oops! No tienes hotsales...</h2>
                        @endif
                        @foreach ($activeHotsales as $activeHotsale)
                            <div class="card-body">
                                <div class="descripcion">
                                    Semana de reserva: {{ $activeHotsale->week }}
                                    <br>
                                    Ubicación: {{ $activeHotsale->home->location }}
                                </div>
                                <div class="links horizontal-list">
                                    <a href="{{ route('hotsale.show', [$activeHotsale->id]) }}">Ver más</a>
                                    @if (Auth::user()->isAdmin())
                                        <a href="{{ route('hotsale.edit', [$activeHotsale->id]) }}">Editar</a>
                                    @endif
                                </div>
                                <hr>
                            </div>
                        @endforeach

                        <h1>hotsales reservados</h1>
                        @if($reservedHotsales->count() == 0)
                            <h2>¡Oops! No tienes hotsales...</h2>
                        @endif
                        @foreach ($reservedHotsales as $reservedHotsale)
                            <div class="card-body">
                                <div class="descripcion">
                                    Semana de reserva: {{ $reservedHotsale->week }}
                                    <br>
                                    Ubicación: {{ $reservedHotsale->home->location }}
                                </div>
                            <div class="links horizontal-list">
                                <a href="{{ route('hotsale.show', [$reservedHotsale->id]) }}">Ver más</a>

                            </div>
                            <hr>
                        </div>
                        @endforeach


                        <h1> hotsales eliminados </h1>
                        @foreach ($trashedHotsales as $trashedHotsale)
                        <div class="card-body">
                            <div class="descripcion">
                                Semana de reserva: {{ $trashedHotsale->week }}
                                <br>
                                Ubicación: {{ $trashedHotsale->home->location }}
                            </div>
                            <div class="links horizontal-list">
                                <a href="{{ route('hotsale.show', [$trashedHotsale->id]) }}">Ver más</a>
                            </div>
                            <hr>
                        </div>
                        @endforeach

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



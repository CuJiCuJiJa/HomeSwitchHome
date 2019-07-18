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
            @if($cantHotsales == 0)
                <h2>¡Oops! No exiten Hotsales actualmente...</h2>
            @else
                <div class="card">
                    <div class="card-header">Hotsales</div>
                    @if (session('status'))
                        <div class="alert alert-success" role="alert">
                            {{ session('status') }}
                        </div>
                    @endif
                    <h1>Hotsales publicados</h1>
                    @if($activeHotsales->count() == 0)
                        <h2>¡Oops! No existen Hotsales publicados actualmente...</h2>
                    @else
                        @foreach ($activeHotsales as $activeHotsale)
                            <div class="card-body">
                                <div class="descripcion">
                                    La semana ofertada comienza el lunes {{ $activeHotsale->week }}.
                                    <br>
                                    Ubicación de la residencia: {{ $activeHotsale->home->location }}.
                                    <br>
                                    Precio: ${{ $activeHotsale->price }}.
                                </div>
                                <div class="links horizontal-list">
                                    <a href="{{ route('hotsale.show', [$activeHotsale->id]) }}">Ver más</a>
                                </div>
                                <hr>
                            </div>
                        @endforeach
                    @endif
                    @if (Auth::user()->isAdmin())
                        <h1>Hotsales no publicados</h1>
                        @if($inactiveHotsales->count() == 0)
                            <h2>Todos los Hotsales se encuentran publicados!</h2>
                        @else
                            @foreach ($inactiveHotsales as $inactiveHotsale)
                                <div class="card-body">
                                    <div class="descripcion">
                                        La semana ofertada comienza el lunes {{ $inactiveHotsale->week }}.
                                        <br>
                                        Ubicación de la residencia: {{ $inactiveHotsale->home->location }}.
                                        <br>
                                        Precio: ${{ $inactiveHotsale->price }}.
                                    </div>
                                    <div class="links horizontal-list">
                                        <a href="{{ route('hotsale.show', [$inactiveHotsale->id]) }}">Ver más</a>
                                        <a href="{{ route('hotsale.edit', [$inactiveHotsale->id]) }}">Editar</a>
                                    </div>
                                    <hr>
                                </div>
                            @endforeach
                        @endif
                        <h1>Hotsales reservados</h1>
                        @if($reservedHotsales->count() == 0)
                            <h2>¡Oops! No tienes Hotsales reservados actualmente...</h2>
                        @else
                            @foreach ($reservedHotsales as $reservedHotsale)
                                <div class="card-body">
                                    <div class="descripcion">
                                        La semana ofertada comienza el lunes {{ $reservedHotsale->week }}.
                                        <br>
                                        Ubicación de la residencia: {{ $reservedHotsale->home->location }}.
                                        <br>
                                        Precio: ${{ $reservedHotsale->price }}.
                                        <br>
                                        Usuario propietario: {{ $reservedHotsale->user->name }} (Email: {{ $reservedHotsale->user->email }})
                                    </div>
                                    <div class="links horizontal-list">
                                        <a href="{{ route('hotsale.show', [$reservedHotsale->id]) }}">Ver más</a>
                                    </div>
                                    <hr>
                                </div>
                            @endforeach
                        @endif
                        <h1>Hotsales eliminados</h1>
                        @if($trashedHotsales->count() == 0)
                            <h2>No tienes Hotsales eliminados actualmente...</h2>
                        @else
                            @foreach ($trashedHotsales as $trashedHotsale)
                                <div class="card-body">
                                    <div class="descripcion">
                                        La semana ofertada comienza el lunes {{ $trashedHotsale->week }}.
                                        <br>
                                        Ubicación de la residencia: {{ $trashedHotsale->home->location }}.
                                        <br>
                                        Precio: ${{ $trashedHotsale->price }}.
                                    </div>
                                    <hr>
                                </div>
                            @endforeach
                        @endif
                    @endif
                </div>
            @endif
            <div class="links horizontal-list">
                @if (Auth::user()->isAdmin())
                    <a href="{{ route('hotsale.create') }}">Agregar Hotsale</a>
                @endif
                <a href="/getSearchHotsale">Buscar Hotsale</a>
            </div>
        </div>
    </div>
</div>
@endsection
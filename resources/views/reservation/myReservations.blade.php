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
                <div class="card-header">Reservas</div>
                @if (session('status'))
                    <div class="alert alert-success" role="alert">
                        {{ session('status') }}
                    </div>
                @endif
                @if($myReservations->count() == 0)
                    <h2>¡Oops! No tienes Hotsales reservados actualmente...</h2>
                @else
                    <h1>Mis reservas</h1>
                    @foreach ($myReservations as $myReservation)
                        <div class="card-body">
                            <div class="descripcion">
                                La semana ofertada comienza el lunes {{ $myReservation->home_idweek }}.
                                <br>
                                Ubicación de la residencia: {{ $myReservation->home->location }}.
                                <br>
                                Reservado por ${{ $myReservation->price }}.
                            </div>
                            <div class="links horizontal-list">
                                <a href="{{ route('hotsale.show', [$myHotsale->id]) }}">Ver más</a>
                            </div>
                            <hr>
                        </div>
                    @endforeach
                @endif
            </div>
            <div class="links horizontal-list">
                <a href="">Buscar Hotsale</a>
                <a href="{{ route('hotsale.index') }}">Hotsales publicados</a>
            </div>
        </div>
    </div>
</div>
@endsection
@extends('layouts.app')

@section('content')
<div class="container mask-white">
    <div class="row justify-content-center">
        <div class="col-12">
            <div class="card">
                <div class="card-header">Residencias disponibles</div>

                    @if (session('status'))
                        <div class="alert alert-success" role="alert">
                            {{ session('status') }}
                        </div>
                    @endif

                    @if (isset($reservations))
                        @foreach ($reservations as $reservation)
                            <div class="card-body description">
                            <div class="descripcion"> 
                                Ubicación: {{ $reservation['home']->location }}
                                <br>
                                Descripción: {{  $reservation['home']->descrip }}
                                <br>
                                La semana inicia el: {{  $reservation['week'] }}
                                <br>
                            </div>

                                <hr>
                            <div class="links horizontal-list">
                                <a href="{{ route('home.show', $reservation['home']->id) }}">Ver más</a>
                                @if (Auth::user()->isPremium())
                                    <?php 
                                        $home_id = $reservation['home']->id;
                                        $week = $reservation['week'];
                                    ?>
                                    <a class="link" href="{{ route('reservation.create', ['home_id'=>$home_id, 'week'=>$week]) }}"> 
                                        Reservar 
                                    </a>
                                @endif
                                </div>
                            <hr>
                            </div>
                        @endforeach
                    @else
                        <div class="alert alert-danger alert-block">

                            <button type="button" class="close" data-dismiss="alert">×</button>
                            <strong>No hay resultados</strong>

                        </div>
                    @endif
            </div>
            <div class="links horizontal-list">
                <a href="{{ URL::previous() }}">Volver</a>
                <a href="{{ route('getSearch.auction') }}">Buscar Subasta</a>
                <br>
                <br>
            </div>
        </div>
    </div>
</div>
@endsection

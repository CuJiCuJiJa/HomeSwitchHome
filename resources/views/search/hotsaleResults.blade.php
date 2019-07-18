@extends('layouts.app')

@section('content')
<div class="container mask-white">
    <div class="row justify-content-center">
        <div class="col-12">
            <div class="card">
                <div class="card-header">Hotsale publicados</div>

                    @if (session('status'))
                        <div class="alert alert-success" role="alert">
                            {{ session('status') }}
                        </div>
                    @endif

                    @if (isset($hotsales))
                        @foreach ($hotsales as $hotsale)
                            <div class="card-body description">
                            <div class="descripcion">
                                Ubicación: {{ $hotsale['home']->location }}
                                <br>
                                Descripción: {{  $hotsale['home']->descrip }}
                                <br>
                                La semana inicia el: {{  $hotsale['week'] }}
                                <br>
                            </div>

                                <hr>
                            <div class="links horizontal-list">
                                <a href="{{ route('hotsale.show', [$hotsale->id]) }}">Ver más</a>
                                @if (Auth::user()->isPremium())
                                    <?php
                                        $home_id = $hotsale['home']->id;
                                        $week = $hotsale['week'];
                                    ?>

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
                <br>
                <br>
            </div>
        </div>
    </div>
</div>
@endsection

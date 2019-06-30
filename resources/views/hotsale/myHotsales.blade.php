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
                    <div class="card-header"> Mis Hotsales </div>
                    @if (session('status'))
                        <div class="alert alert-success" role="alert">
                            {{ session('status') }}
                        </div>
                    @endif

                    @if ($myHotsales->count() == 0)
                        <h2>¡Oops! No tienes subastas...</h2>
                    @else
                        @foreach ($myHotsales as $hotsale)
                            <div class="card-body">
                            <div class="descripcion">
                                    Semana: {{ $hotsale->week }}
                                    <br>
                                    Ubicación: {{ $hotsale->home->location }}
                                </div>

                                <div class="links horizontal-list">
                                    <a href="{{ route('hotsale.show', $hotsale->id) }}">Ver más</a>
                                </div>
                                <hr>
                            </div>
                        @endforeach
                    @endif
                </div>
        </div>
    </div>
</div>
@endsection

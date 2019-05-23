@extends('layouts.app')

@section('content')
<div class="container mask-white">
    <div class="row justify-content-center">
        <div class="col-12">
            <div class="card">
                <div class="card-header">Subastas</div>
                    
                    @if (session('status'))
                        <div class="alert alert-success" role="alert">
                            {{ session('status') }}
                        </div>
                    @endif

                    @if (isset($auctions))
                        @foreach ($auctions as $auction)
                            <div class="card-body description">
                                Empieza el:{{ $auction->starting_date }}
                                La semana de ocupación comienza el {{ $auction->week }}
                                Ubicación de la residencia: {{ $auction->home->location }}
                                <hr>
                                <div class="links horizontal-list">
                                    <a href="{{ route('auction.show', $auction->id) }}">Ver más</a>
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
                <a href="{{ route('auction.create') }}">Agregar Subasta</a>
                <a href="{{ route('getSearch.auction') }}">Buscar Subasta</a>
                <br>
                <br>
            </div>
        </div>
    </div>
</div>
@endsection

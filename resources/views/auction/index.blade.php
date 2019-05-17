@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">Subastas</div>
                
                    @if (session('status'))
                        <div class="alert alert-success" role="alert">
                            {{ session('status') }}
                        </div>
                    @endif
                    @foreach ($auctions as $auction)
                        <div class="card-body">
                            <a href="{{ route('auction.show', [$auction->id]) }}">Ver más</a>
                            Empieza el:{{ $auction->starting_date }}
                            El precio base es: {{ $auction->base_price }} (En realidad este valor no se deberia mostrar)
                            El numero de la semana del año es: {{ $auction->week }}
                            El año de la subasta es: {{ $auction->year }}
                            <hr>
                        </div>
                    @endforeach
            </div>
            <a href="{{ route('auction.create') }}">Agregar Subasta</a>
        </div>
    </div>
</div>
@endsection

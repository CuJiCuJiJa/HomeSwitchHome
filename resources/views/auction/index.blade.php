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
                    @foreach ($activeAuctions as $activeAuction)
                        <div class="card-body">
                            <a href="{{ route('auction.show', [$activeAuction->id]) }}">Ver más</a>
                            Empieza el:{{ $activeAuction->starting_date }}
                            El precio base es: {{ $activeAuction->base_price }} (En realidad este valor no se deberia mostrar)
                            El numero de la semana del año es: {{ $activeAuction->week }}
                            El año de la subasta es: {{ $activeAuction->year }}
                            <hr>
                        </div>
                    @endforeach
            </div>
            <a href="{{ route('auction.create') }}">Agregar Subasta</a>
        </div>
    </div>
</div>
@endsection

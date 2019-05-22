@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            @if(session('success'))
                {{ session('success') }}
            @endif
            @if($cantAuctions == 0)
                <h2>Oops! No existen subastas actualmente...</h2>
            @else
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
                                La semana de ocupación comienza el {{ $activeAuction->week }}
                                Ubicación de la residencia: {{ $activeAuction->home->location }}
                                <hr>
                            </div>
                        @endforeach
                </div>
            @endif
            <a href="{{ route('auction.create') }}">Agregar Subasta</a>
        </div>
    </div>
</div>
@endsection

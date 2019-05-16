@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">Subasta numero {{ $auction->id }}</div>
                @if (session('status'))
                    <div class="alert alert-success" role="alert">
                        {{ session('status') }}
                    </div>
                @endif
                <div class="card-body">
                    Empieza el:{{ $auction->starting_date }}
                    El precio base es: {{ $auction->base_price }} (En realidad este valor no se deberia mostrar)
                    El numero de la semana del año es: {{ $auction->week }}
                    El año de la subasta es: {{ $auction->year }}
                </div>
            </div>
            <form action="{{ route('auction.destroy', $auction->id) }}" method="POST">
                {{ csrf_field() }}
                {{ method_field('DELETE') }}
                <button type="submit" class="btn btn-primary">Eliminar</button>
            </form>
        </div>
    </div>
</div>
@endsection

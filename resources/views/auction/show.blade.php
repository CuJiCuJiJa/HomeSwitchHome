@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            @if(session('success'))
                {{ session('success') }}
            @endif
            <div class="card">
                <div class="card-header">Subasta numero {{ $auction->id }}</div>
                @if (session('status'))
                    <div class="alert alert-success" role="alert">
                        {{ session('status') }}
                    </div>
                @endif
                <div class="card-body">
                    Comienza el {{ $auction->starting_date }}
                    <br>
                    La semana de ocupación comienza el {{ $auction->week }}
                    <br>
                    Ubicación de la residencia: {{ $auction->home->location }}
                </div>
            </div>
            <br>
            <a href="{{ route('auction.edit', $auction) }}">Editar</a>
            <form action="{{ route('auction.destroy', $auction->id) }}" method="POST">
                {{ csrf_field() }}
                {{ method_field('DELETE') }}
                <button type="submit" class="btn btn-primary">Eliminar</button>
                <a href="{{ URL::previous() }}">Volver</a>
            </form>
        </div>
    </div>
</div>
@endsection

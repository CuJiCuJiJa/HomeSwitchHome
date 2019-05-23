@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            @if(session('success'))
                {{ session('success') }}
            @endif
            <div class="card">
                <div class="card-header">Subasta al {{ $auction->week }}</div>
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
                    <br>
                    Mayor puja hasta el momento: ${{ $auction->best_bid_value }}
                </div>
                @if(session('error'))
                    {{ session('error') }}
                @endif
                    
                @if ($auction->starting_date < \Carbon\Carbon::now() && $auction->end_date > \Carbon\Carbon::now())
                    <form action="{{ route('user.bid', $auction->id) }}" method="POST">
                        {{ csrf_field() }}
                    
                        <input type="real" class="form-control" id="bid_value" name="bid_value" placeholder="Ingrese el monto a pujar">
                        @if($errors->has('bid_value'))
                          {{ $errors->first('bid_value') }}
                        @endif
                        <button type="submit" class="btn btn-primary">Pujar!</button>
                    </form>
                @endif

            </div>
            <br>
            <a href="{{ route('auction.edit', $auction) }}">Editar</a>
            <form action="{{ route('auction.destroy', $auction->id) }}" method="POST">
                {{ csrf_field() }}
                {{ method_field('DELETE') }}
                <button type="submit" class="btn btn-primary">Eliminar</button>
                <a href="{{ route('auction.index') }}">Volver</a>
            </form>
        </div>
    </div>
</div>
@endsection

@extends('layouts.app')

@section('content')
<div class="container mask-white">
    <div class="row justify-content-center">
        <div class="col-12">

            @if(session('success'))
                <div class="exito horizontal-list">
                    {{ session('success') }}
                </div>
            @endif

            <div class="card">
                <div class="card-header">Subasta</div>

                @if (session('status'))
                    <div class="alert alert-success" role="alert">
                        {{ session('status') }}
                    </div>
                @endif

                <div class="card-body descripcion">
                    <div class="descripcion">
                        La subasta abrira el {{ $auction->starting_date }} y cerrara 72hs mas tarde.
                        <br>
                        La semana subastada comienza el lunes {{ $auction->week }}.
                        <br>
                        Ubicación de la residencia: {{ $auction->home->location }}.
                        <br>
                        Hasta el momento: ${{ $auction->best_bid_value }}.
                    </div>
                </div>

                @if(session('error'))
                    <div class="fallo horizontal-list">
                        {{ session('error') }}
                    </div>
                @endif
                    
                @if ($auction->starting_date < \Carbon\Carbon::now() && $auction->end_date > \Carbon\Carbon::now())
                    
                    <form action="{{ route('user.bid', $auction->id) }}" method="POST">
                        {{ csrf_field() }}
                    
                        <input type="real" class="form-control" id="bid_value" name="bid_value" placeholder="Ingrese el monto a pujar">
                        
                        @if($errors->has('bid_value'))
                            <div class="fallo horizontal-list">
                                {{ $errors->first('bid_value') }}
                            </div>
                        @endif
                        
                        <div class="links horizontal-list">
                            <button type="submit" class="btn btn-primary">Pujar!</button>
                        </div>


                    </form>
                @endif

                @if ($winner != null)
                    <div class="card-body">
                        Usuario ganador: {{ $winner->name, $winner->email }}
                    </div>
                @endif

                @if ($auction->end_date < \Carbon\Carbon::now() && $winner == null && $auction->best_bid_value >= $auction->base_price)
                    <form action="{{ route('admin.adjudicar', $auction->id) }}" method="POST">
                        {{ csrf_field() }}
                                        
                        <button type="submit" class="btn btn-primary">Adjudicar a ganador</button>
                    </form>
                @endif

                @if ($auction->end_date < \Carbon\Carbon::now())
                    <h2>Subasta finalizada</h2>
                @endif
            </div>

            <br>

            <div class="links horizontal-list">

                <form action="{{ route('auction.destroy', $auction->id) }}" method="POST">
                    {{ csrf_field() }}
                    {{ method_field('DELETE') }}

                    <button type="submit" onclick="return confirm('¿Desea borrar la subasta?');" class="btn btn-primary">Eliminar</button>
                </form>

                <a href="{{ route('auction.edit', $auction) }}">Editar</a>
                <a href="{{ route('auction.index') }}">Volver</a>
                <br>
                <br>
            </div>
            
        </div>
    </div>
</div>
@endsection

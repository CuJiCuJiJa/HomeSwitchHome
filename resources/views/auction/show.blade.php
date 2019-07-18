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

                @if ($auction->starting_date <= \Carbon\Carbon::now()->toDateString() && $auction->end_date >= \Carbon\Carbon::now()->toDateString() && !Auth::user()->isAdmin())

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

                @if($winner->id == Auth::user()->id)

                    <form action="{{ route('user.cancelAuction', ['auction_id' => $auction->id]) }}" method="POST">
                        {{ csrf_field() }}
                        <button type="submit" onclick="return confirm('¿Desea cancelar la reserva de su subasta ganada?')" class="btn btn-primary">Cancelar reserva</button>
                    </form>
                @endif

                @if ($auction->end_date < \Carbon\Carbon::now()->toDateString() && $winner == null && $auction->best_bid_value >= $auction->base_price)
                    <form action="{{ route('admin.adjudicar', ['auction_id' => $auction->id]) }}" method="POST">
                        {{ csrf_field() }}
                        <button type="submit" class="btn btn-primary">Adjudicar a ganador</button>
                    </form>
                @endif

                @if ($auction->end_date < \Carbon\Carbon::now()->toDateString() && $winner == null &&  $auction->best_bid_value < $auction->base_price)
                        <h2>Ningún usuario superó el precio base</h2>
                @endif

                @if ($auction->end_date < \Carbon\Carbon::now()->toDateString())
                    <h2>Subasta finalizada</h2>
                @endif
            </div>
            @if (Auth::user()->isAdmin() && $auction->winner_id == null)
                <form action="{{ route('auction.destroy', $auction->id) }}" method="POST">
                    {{ csrf_field() }}
                    {{ method_field('DELETE') }}

                    <button type="submit" onclick="return confirm('¿Desea borrar la subasta?');" class="btn btn-primary">Eliminar</button>
                </form>
            @endif

            <br>
            @if (Auth::user()->isAdmin())

                @if ($auction->isTrashed)
                    <div class="links horizontal-list">

                        <form action="{{ route('auction.destroy', $auction->id) }}" method="POST">
                            {{ csrf_field() }}
                            {{ method_field('DELETE') }}

                            <button type="submit" onclick="return confirm('¿Desea borrar la subasta?');" class="btn btn-primary">Eliminar</button>
                        </form>
                        <br>
                        <br>
                    </div>
                @endif
            @endif
            <div class="links horizontal-list">
                <a href="{{ route('auction.index') }}">Volver</a>
            </div>
            @if (Auth::user()->isAdmin())
                <div class="links horizontal-list">
                    <h2>Pujas</h2>
                    @if (!$bids->count() > 0)
                        <h3>No existen pujas</h3>
                    @else

                        @foreach ($bids as $bid)
                            <div class="descripcion">
                                @if ($bid->best_bid)
                                    Mejor puja:
                                @endif
                                Nombre de usuario:{{$bid->user->name}}
                                Email de usuario:{{$bid->user->email}}
                                Valor de la puja:{{$bid->value}}
                            </div>
                                @if ($bid->user->card_verification == false)
                                    El usuario no es válido: No posee un número de tarjeta verificado.
                                @endif
                                @if ($bid->user->hasAvailableWeek() == false)
                                    El usuario no es válido: No posee créditos disponibles.
                                @endif
                                @if ($bid->user->hasHotsale($auction->week) || $bid->user->hasAuction($auction->week) || $bid->user->hasReservation($auction->week))
                                    El usuario no es válido: El usuario posee la semana ocupada.
                                @endif
                            <br>


                        @endforeach
                    @endif
                @endif
            </div>

        </div>
    </div>
</div>
@endsection

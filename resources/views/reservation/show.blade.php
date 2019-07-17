@extends('layouts.app')

@section('content')
<div class="container mask-white">
    <div class="row justify-content-center">
        <div class="col-12">


            <div class="card">
                <div class="card-header">Reserva</div>
                @if(session('success'))
                <div class="exito horizontal-list">
                    {{ session('success') }}
                </div>
            @endif


                @if (session('status'))
                    <div class="alert alert-success" role="alert">
                        {{ session('status') }}
                    </div>
                @endif

                <div class="card-body descripcion">
                    <div class="descripcion">
                        La semana reservada comienza el lunes {{ $reservation->week }}.
                        <br>
                        Ubicación de la residencia: {{ $reservation->home->location }}.

                    </div>
                </div>

                @if(session('error'))
                    <div class="fallo horizontal-list">
                        {{ session('error') }}
                    </div>
                @endif
            <br>

            <div class="links horizontal-list">
                <form action="{{route('reservation.destroy', $reservation->id)}}" method="POST">
                    {{ csrf_field() }}
                    {{ method_field('DELETE') }}
                    <input class="btn btn-danger" type="submit" value="Cancelar reserva" onclick="return confirm('¿Desea cancelar la reserva?')">

                </form>
            </div>

            <div class="links horizontal-list">
                <a href="{{URL::previous()}}">Volver</a>
            </div>
        </div>
    </div>
</div>
@endsection

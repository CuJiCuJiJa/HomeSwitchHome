@extends('layouts.app')

@section('content')
<div class="container mask-white">

    <div class="row justify-content-center">

        <div class="col-12 text-md-center full-height">

            @if(session('success'))
                <div class="exito horizontal-list">
                    {{ session('success') }}
                </div>
            @endif


                <div class="card">
                    <div class="card-header"> Usuarios </div>
                    @if (session('status'))
                        <div class="alert alert-success" role="alert">
                            {{ session('status') }}
                        </div>
                    @endif
                    <h1>Usuarios Premium </h1>
                    @if ($premiumUsers->count() == 0)
                        <h2>¡Oops! No tienes usuarios...</h2>
                    @else
                        @foreach ($premiumUsers as $user)
                            <div class="card-body">
                                <div class="descripcion">
                                    Nombre: {{ $user->name }}
                                    <br>
                                    email: {{ $user->email }}
                                    <br>
                                    número de tarjeta: {{$user->card_number}}
                                </div>
                            <div class="links horizontal-list">

                        @endforeach
                    @endif
                    <h1>Usuarios Lowcost </h1>
                    @if ($lowcostUsers->count() == 0)
                        <h2>¡Oops! No tienes usuarios...</h2>
                    @else
                        @foreach ($lowcostUsers as $user)
                            <div class="card-body">
                                    <div class="descripcion">
                                            Nombre: {{ $user->name }}
                                            <br>
                                            email: {{ $user->email }}
                                            <br>
                                            número de tarjeta: {{$user->card_number}}
                                        </div>
                                        <div class="links horizontal-list">

                        @endforeach
                    @endif
                    <h1>Peticiones de verificación de tarjeta</h1>
                    @if ($cardUsers->count() == 0)
                        <h2>¡Oops! No tienes usuarios...</h2>
                    @else
                        @foreach ($cardUsers as $user)
                            <div class="card-body">
                              <div class="descripcion">
                                    Nombre: {{ $user->name }}
                                    <br>
                                    email: {{ $user->email }}
                                    <br>
                                    número de tarjeta: {{$user->card_number}}
                                </div>
                                <div class="links horizontal-list">
                                        <form action="{{ route('admin.approbe', $user->id) }}" method="POST">
                                            {{ csrf_field() }}

                                            <button type="submit" class="btn btn-primary">Aprobar</button>
                                        </form>
                                        <form action="{{ route('admin.decline', $user->id) }}" method="POST">
                                            {{ csrf_field() }}

                                            <button type="submit" class="btn btn-primary">Rechazar  </button>
                                    </form>
                        @endforeach
                    @endif
                </div>
            <div class="links horizontal-list">
            </div>
        </div>
    </div>
</div>
@endsection

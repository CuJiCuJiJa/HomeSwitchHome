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
                <div class="card-header">Hotsale</div>
                @if (session('status'))
                    <div class="alert alert-success" role="alert">
                        {{ session('status') }}
                    </div>
                @endif
                <div class="card-body descripcion">
                    <div class="descripcion">
                        La semana ofertada comienza el lunes {{ $hotsale->week }}.
                        <br>
                        Ubicación de la residencia: {{ $hotsale->home->location }}.
                        <br>
                        Precio: ${{ $hotsale->price }}.
                        <br>
                        @if ($hotsale->user_id != null)
                            <h2>Este Hotsale esta reservado por: {{ $hotsale->user->name }} (Email: {{ $hotsale->user->email}})</h2>
                        @endif
                    </div>
                </div>
                <!-- @if(session('error'))
                    <div class="fallo horizontal-list">
                        {{ session('error') }}
                    </div>
                @endif -->
            </div>
            @if (Auth::user()->isAdmin() && $hotsale->active == 0 && $hotsale->user_id == null)
                <div class="links horizontal-list">
                    <form action="{{ route('hotsale.activate', $hotsale->id) }}" method="POST">
                        {{ csrf_field() }}
                        {{ method_field('POST') }}
                        <button type="submit" onclick="return confirm('¿Desea publicar el Hotsale?')" class="btn btn-primary">Publicar</button>
                    </form>
                    <form action="{{ route('hotsale.destroy', $hotsale->id) }}" method="POST">
                        {{ csrf_field() }}
                        {{ method_field('DELETE') }}
                        <button type="submit" onclick="return confirm('¿Desea borrar el Hotsale?')" class="btn btn-primary">Eliminar</button>
                    </form>
                </div>
            @endif
            @if (Auth::user()->isAdmin() && $hotsale->active == 1)
                <div class="links horizontal-list">
                    <form action="{{ route('hotsale.desactivate', $hotsale->id) }}" method="POST">
                        {{ csrf_field() }}
                        {{ method_field('POST') }}
                        <button type="submit" onclick="return confirm('¿Desea retirar el Hotsale?')" class="btn btn-primary">Retirar</button>
                    </form>
                </div>
            @endif
            <div class="links horizontal-list">
                <a href="{{ route('hotsale.index') }}">Volver</a>
            </div>
        </div>
    </div>
</div>

@endsection
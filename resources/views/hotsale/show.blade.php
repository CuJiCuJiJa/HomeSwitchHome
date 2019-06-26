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
                <div class="card-header">
                    Hotsale
                </div>
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
                    </div>
                </div>
                @if(session('error'))
                    <div class="fallo horizontal-list">
                        {{ session('error') }}
                    </div>
                @endif
                @if ($hotsale->user_id != null)
                    <h2>Este Hotsale esta reservado por: {{ $hotsale->user->name }}</h2>
                @endif
            </div>
            @if (Auth::user()->isAdmin() && $hotsale->user_id == null)
                <form action="{{ route('hotsale.destroy', $hotsale->id) }}" method="POST">
                    {{ csrf_field() }}
                    {{ method_field('DELETE') }}
                    <button type="submit" onclick="return confirm('¿Desea borrar el Hotsale?');" class="btn btn-primary">Eliminar</button>
                </form>
            @endif
            <br>
            <div class="links horizontal-list">
                <a href="{{ route('hotsale.index') }}">Volver</a>
            </div>
        </div>
    </div>
</div>

@endsection
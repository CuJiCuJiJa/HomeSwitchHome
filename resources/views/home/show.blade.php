@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            @if(session('success'))
                {{ session('success') }}
            @endif
            <div class="card">
                <div class="card-header">Residencia número {{ $home->id }}</div>
                @if (session('status'))
                    <div class="alert alert-success" role="alert">
                        {{ session('status') }}
                    </div>
                @endif
                <div class="card-body">
                    Ubicación: {{ $home->location }}
                    <br>
                    Descripción: {{ $home->descrip }}
                    <br><br>
                    <a href="{{ route('home.edit', $home->id) }}">Editar</a>
                    <form action="{{ route('home.anular', $home->id) }}" method="POST">
                        {{ csrf_field() }}
                        {{ method_field('POST') }}
                        <button type="submit" class="btn btn-primary">Anular</button>
                    </form>
                    <a href="{{ route('home.index') }}">Listado de Residencias</a>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

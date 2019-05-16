@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">Residencias</div>
                    @if (session('status'))
                        <div class="alert alert-success" role="alert">
                            {{ session('status') }}
                        </div>
                    @endif
                    @foreach ($homes as $home)
                        <div class="card-body">
                            <a href="{{ route('home.show', $home->id) }}">Ver más</a>
                            Descripción: {{ $home->descrip }}
                            Ubicación: {{ $home->location }}
                            <a href="{{ route('home.edit', $home->id) }}">Editar</a>
                            <hr>
                        </div>
                    @endforeach
            </div>
        </div>
    </div>
</div>
@endsection

@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">Residencia numero {{ $home->id }}</div>
                @if (session('status'))
                    <div class="alert alert-success" role="alert">
                        {{ session('status') }}
                    </div>
                @endif
                <div class="card-body">
                    Descripción: {{ $home->descrip }}
                    Ubicación: {{ $home->location }}
                    <a href="{{ route('home.edit', $home->id) }}">Editar</a>
                    <form action="{{ route('home.destroy', $home->id) }}" method="POST">
                        {{ csrf_field() }}
                        {{ method_field('DELETE') }}
                        <button type="submit" class="btn btn-primary">Eliminar</button>
                        <a href="{{ URL::previous() }}">Volver</a>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@extends('layouts.app')

@section('content')
<div class="container mask-white">
    <div class="row justify-content-center">
        <div class="col-12">

            @if(session('success'))
                {{ session('success') }}
            @endif

            <div class="card">

                <div class="card-header"> Residencia </div>

                @if (session('status'))
                    <div class="alert alert-success" role="alert">
                        {{ session('status') }}
                    </div>
                @endif

                <div class="card-body">
<<<<<<< HEAD
                    <div class="descripcion">
                        Ubicación: {{ $home->location }}
                        <br>
                        Descripción: {{ $home->descrip }}
                        <br><br>
                    </div>

                    <div class="links horizontal-list">
                        <form action="{{ route('home.destroy', $home->id) }}" method="POST">
                            {{ csrf_field() }}
                            {{ method_field('DELETE') }}
                            <button type="submit" class="btn btn-primary">Anular</button>
                        </form>
                        <a href="{{ route('home.edit', $home->id) }}">Editar</a>
                        <a class="link" href="{{ route('home.index') }}">Listado de Residencias</a>
                    </div>
=======
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
>>>>>>> a6ffeae0dca92f09c88f185f1c5756ae41aaec5a
                </div>

            </div>

        </div>
    </div>
</div>
@endsection

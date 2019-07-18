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

          <!--   @if ($errors->any())
            <div class="alert alert-danger">
                <ul>
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
            @endif -->


           @if(session('error'))
            <div class="fallo horizontal-list">
                {{ session('error') }}
            </div>
            @endif


            <div class="card">

                <div class="card-header"> Residencia </div>

                @if (session('status'))
                    <div class="alert alert-success" role="alert">
                        {{ session('status') }}
                    </div>
                @endif

                <div class="card-body">
                    <div class="descripcion">
                        Ubicación: {{ $home->location }}
                        <br>
                        Descripción: {{ $home->descrip }}
                        <br><br>
                    </div>

                    <div class="links horizontal-list">
                    @if (Auth::user()->isAdmin())

<<<<<<< HEAD
                    <form action="{{ route('hotsale.destroy', $hotsale->id) }}" method="POST">
                        {{ csrf_field() }}
                        {{ method_field('DELETE') }}
                        <button type="submit" onclick="return confirm('¿Desea eliminar la Residencia?')" class="btn btn-primary">Eliminar</button>
                    </form>
=======
                        <form action="{{ route('home.anular', $home->id) }}" method="POST">
                            {{ csrf_field() }}

                            <button type="submit" onclick="return confirm('¿Desea anular la residencia?');"  class="btn btn-primary"> Anular </button>
                        </form>
>>>>>>> eae9a92c6164a8d0c84a0ddd7bd97062fe0f3735

                        <a href="{{ route('home.edit', $home->id) }}"> Editar </a>
                    @endif
                    @if (Auth::user()->isAdmin())
                        <a class="link" href="{{ route('home.index') }}"> Listado de Residencias </a>
                    @endif

                    </div>
                </div>

            </div>

        </div>
    </div>
</div>
@endsection

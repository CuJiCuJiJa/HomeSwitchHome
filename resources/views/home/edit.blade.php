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

                <div class="card-header"> Residencia </div>

                <div class="card-body">

                    @if (session('status'))
                        <div class="alert alert-success" role="alert">
                            {{ session('status') }}
                        </div>
                    @endif

                    <form action="{{ route('home.update', $home->id) }}" method="POST">

                        {{ csrf_field() }}
                        {{ method_field('PUT') }}
                        <div class="descripcion">
                        <div class="form-group">
                            <label for="location">Ubicación</label>
                            <input type="text" class="form-control" id="location" name="location" placeholder="Ingresar ubicación" value="{{ $home->location }}" readonly>
                            
                            <span>
                                @if($errors->has('location'))
                                  {{ $errors->first('location') }}
                                @endif
                            </span>

                        </div>

                        <div class="form-group">
                            <label for="starting_date">Descripción</label>
                            <input type="text" class="form-control" id="descrip" name='descrip' placeholder="Ingresar una descripción" value="{{ $home->descrip }}">
                        </div>

                        <div class="links horizontal-list">   
                            <button type="submit" class="btn btn-primary">Confirmar</button>
                            <a href="{{ route('home.index') }}">Cancelar</a>
                        </div>
</div>

                    </form>

                </div>

            </div>

        </div>
    </div>
</div>
@endsection

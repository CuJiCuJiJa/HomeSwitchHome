@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            @if(session('success'))
                {{ session('success') }}
            @endif
            <div class="card">
                <div class="card-header">Residencia numero {{ $home->id }}</div>
                <div class="card-body">
                    @if (session('status'))
                        <div class="alert alert-success" role="alert">
                            {{ session('status') }}
                        </div>
                    @endif
                    <form action="{{ route('home.update', $home->id) }}" method="POST">
                        {{ csrf_field() }}
                        {{ method_field('PUT') }}
                        <div class="form-group">
                            <label for="location">Ubicación</label>
                            <input type="text" class="form-control" id="location" name="location" placeholder="Ingresar ubicación" value="{{ $home->location }}">
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
                        <button type="submit" class="btn btn-primary">Submit</button>
                        <a href="{{ URL::previous() }}">Cancelar</a>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

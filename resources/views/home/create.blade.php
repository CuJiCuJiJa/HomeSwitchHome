@extends('layouts.app')

@section('content')
<div class="container mask-white">
    <div class="row justify-content-center">
        <div class="col-12">
            
            
            <div class="card">

                <div class="card-header">Crear Residencia</div>

                <div class="card-body">
                  @if (session('status'))
                    <div class="alert alert-success" role="alert">
                        {{ session('status') }}
                    </div>
                  @endif

                  <form action="{{ route('home.store') }}" method="POST">
                    {{ csrf_field() }}


                    <div class="form-group">
                      <label for="location">Ubicación</label>
                      <input type="text" class="form-control" id="location" name="location" placeholder="Ingresar ubicación" value="{{ old('location') }}">
                      <span>
                        @if($errors->has('location'))
                          <div class="fallo horizontal-list">  
                            {{ $errors->first('location') }}
                          </div>
                        @endif
                      </span>
                    </div>


                    <div class="form-group">
                      <label for="starting_date">Descripción</label>
                      <input type="text" class="form-control" id="descrip" name='descrip' placeholder="Ingresar una descripción" value="{{ old('descrip') }}">
                    </div>

                    <div class="horizontal-list links">
                      <button type="submit" class="btn btn-primary">Crear</button>
                      <a href="{{ route('home.index') }}">Cancelar</a>
                    </div>

                  </form>
                  
                </div>

            </div>

        </div>
    </div>
</div>
@endsection

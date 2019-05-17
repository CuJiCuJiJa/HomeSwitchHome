@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">Cargar Residencia</div>
                <div class="card-body">
                  @if (session('status'))
                    <div class="alert alert-success" role="alert">
                        {{ session('status') }}
                    </div>
                  @endif
                  <form action="{{ route('home.store') }}" method="POST">
                    {{ csrf_field() }}
                    <div class="form-group">
                      <label for="location">Ubicación:</label>
                      <input type="text" class="form-control" id="location" name="location" placeholder="Ingresar ubicación">
                    </div>
                    <div class="form-group">
                      <label for="starting_date">Descripción</label>
                      <input type="text" class="form-control" id="descrip" name='descrip' placeholder="Ingresar una descripción">
                    </div>
                    <button type="submit" class="btn btn-primary">Submit</button>
                  </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

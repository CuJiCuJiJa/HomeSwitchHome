@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">Buscar Subasta</div>
                <div class="card-body">
                    <form action="{{ route('postSearch.auction') }}" method="POST">
                      {{ csrf_field() }}
                      <div class="form-group">
                        <label for="week">Semana:</label>
                        <input type="date" class="form-control" id="week" name="week" placeholder="Ingresar semana">
                      </div>
                      <div class="form-group">
                        <label for="location">Lugar</label>
                        <input type="text" class="form-control" id="location" name='location' placeholder="locación">
                      </div>
                      <button type="submit" class="btn btn-primary">Buscar</button>
                      <a href="{{ URL::previous() }}">Cancelar</a>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

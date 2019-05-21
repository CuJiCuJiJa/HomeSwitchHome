@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">Editar Subasta</div>
                <div class="card-body">
                    <form action="{{ route('auction.update', $auction->id) }}" method="POST">
                      {{ csrf_field() }}
                      {{ method_field('PUT') }}
                      <div class="form-group">
                        <label for="starting_date">Fecha de inicio</label>
                        <input type="date" class="form-control" id="starting_date" name='starting_date' value="{{ $auction->starting_date }}">
                        @if($errors->has('starting_date'))
                          {{ $errors->first('starting_date') }}
                        @endif
                      </div>
                      <div class="form-group">
                        <label for="home_id">Residencia</label>
                        <select class="form-control" id="home_id" name="home_id">
                          @foreach($activeHomes as $activeHome)
                            @if($activeHome->id == $auction->home_id)
                              <option value="{{ $activeHome->id }}" selected>{{ $activeHome->location }}</option>
                            @else
                              <option value="{{ $activeHome->id }}">{{ $activeHome->location }}</option>
                            @endif
                          @endforeach
                        </select>
                        @if($errors->has('home_id'))
                          {{ $errors->first('home_id') }}
                        @endif
                        @if(session('sameAuction'))
                          {{ session('sameAuction') }}
                        @endif
                      </div>
                      <div class="form-group">
                        <label for="base_price">Monto base</label>
                        <input type="real" class="form-control" id="base_price" name="base_price" placeholder="Ingrese el monto base en $" value="{{ $auction->base_price }}">
                        @if($errors->has('base_price'))
                          {{ $errors->first('base_price') }}
                        @endif
                      </div>
                      <br>
                      <button type="submit" class="btn btn-primary">Guardar cambios</button>
                      <a href="{{ route('auction.show', $auction) }}">Cancelar</a>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

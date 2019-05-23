@extends('layouts.app')

@section('content')

<div class="container mask-white">
  <div class="row justify-content-center">
    <div class="col-12">

      <div class="card">
        <div class="card-header">Editar Subasta</div>
          <div class="card-body">

            <form action="{{ route('auction.update', $auction->id) }}" method="POST">
            {{ csrf_field() }}
            {{ method_field('PUT') }}

            <div class="form-group">
              <label for="starting_date">Fecha de inicio</label>
              <input type="date" class="form-control" required id="starting_date" name='starting_date' value="{{ $auction->starting_date }}" readonly>
            </div>

            <div class="form-group">
              <label for="home_id">Residencia</label>
              <input type="text" class="form-control" required id="home" name='home' value="{{$auction->home->id}}" placeholder="{{$auction->home->location}}" readonly>
             
              @if(session('sameAuction'))
                {{ session('sameAuction') }}
              @endif
            </div>

            <div class="form-group">
              <label for="base_price">Monto base</label>
              <input type="integer" class="form-control" id="base_price" name="base_price" placeholder="Ingrese el monto base en $" value="{{ $auction->base_price }}">
              @if($errors->has('base_price'))
                <div class="fallo horizontal-list">
                  {{ $errors->first('base_price') }}
                </div>
              @endif
            </div>
            
            <br>

            <div class="links horizontal-list">
              <button type="submit" class="btn btn-primary">Guardar cambios</button>
              <a href="{{ route('auction.show', $auction) }}">Cancelar</a>
            </div>

            </form>

          </div>
        </div>
      </div>   

    </div>
  </div>
</div>
@endsection

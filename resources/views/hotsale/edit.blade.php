@extends('layouts.app')

@section('content')

<div class="container mask-white">
  <div class="row">
    <div class="col-12">
      <div class="card">
        <div class="card-header">Editar Hotsale</div>
          <div class="card-body">
            <form action="{{ route('hotsale.update', $hotsale->id) }}" method="POST">
              {{ csrf_field() }}
              {{ method_field('PUT') }}
              <?php
                $date = \Carbon\Carbon::now()->addMonths(6);
                if (!$date->isMonday()){
                  $date = $date->startOfWeek();
                }
                $date = $date->format('Y-m-d');
              ?>
              <div class='form-group'>
                <label for="weekAuctioned">Semana a ofertar</label>
                <br>
                <input type="date" name="weekOffered" id="weekOffered" min="{{$date}}" value="{{ $hotsale->week }}" readonly>
                <br>
                @if($errors->has('weekOffered'))
                  <div class="fallo horizontal-list">
                    {{ $errors->first('weekOffered') }}
                  </div>
                @endif
              </div>
              <div class="form-group">
                <label for="home_id">Residencia</label>
                <input type="text" class="form-control" id="home_id" name="home_id" value="{{ $hotsale->home->location }}" required readonly>
                @if($errors->has('home_id'))
                  <div class="fallo horizontal-list">
                    {{ $errors->first('home_id') }}
                  </div>
                @endif
                @if(session('isOccupied'))
                  <div class="fallo horizontal-list">
                    {{ session('isOccupied') }}
                  </div>
                @endif
              </div>
              <div class="form-group">
                <label for="base_price">Precio</label>
                <input type="real" class="form-control" id="price" name="price" placeholder="Ingrese el precio en $" value="{{ $hotsale->price }}">
                @if($errors->has('price'))
                  <div class="fallo horizontal-list">
                    {{ $errors->first('price') }}
                  </div>
                @endif
              </div>
              <br>
              <div class="links horizontal-list">
                <button type="submit" class="btn btn-primary">Editar</button>
                <a href="{{ route('hotsale.index') }}">Cancelar</a>
              </div>
            </form>
          </div>
        </div>
      </div>
    </div>
  </div>
</div>

@endsection

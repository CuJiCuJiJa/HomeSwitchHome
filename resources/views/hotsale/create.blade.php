@extends('layouts.app')

@section('content')

<div class="container mask-white">
  <div class="row">
    <div class="col-12">
      <div class="card">
        <div class="card-header">Crear Hotsale</div>
          <div class="card-body">
            <form action="{{ route('hotsale.store') }}" method="POST">
              {{ csrf_field() }}
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
                <input type="date" name="weekOffered" id="weekOffered" min="{{$date}}" value="{{ old('weekOffered') }}"> <br>
                @if($errors->has('weekOffered'))
                  <div class="fallo horizontal-list">
                    {{ $errors->first('weekOffered') }}
                  </div>
                @endif
              </div>

              <script>
                $('#weekOffered').change(function(){
                  var month = parseInt($(this).val().substring(5, 7));
                  var year = parseInt($(this).val().substring(0, 4));
                  if(month > 6 ){
                    month = (month - 6);
                    month = '0' + month;
                  }else{
                    if(month < 4 ){
                      month = '0' + (month + 6);
                    }else{
                      month = (month + 6);
                    }
                    year = (year - 1);
                  }
                  var hotsaleDate = month + '/' + $(this).val().substring(8, 10) +'/' + year;
                  $('#starting_date').val(hotsaleDate);
                });
              </script>

              <div class="form-group">
                <label for="home_id">Residencia</label>
                <select class="form-control" id="home_id" name="home_id">
                  <option value="">Seleccione una residencia</option>
                    @foreach($activeHomes as $activeHome)
                      @if($activeHome->id == old('home_id'))
                        <option value="{{ $activeHome->id }}" selected>{{ $activeHome->location }}</option>
                      @else
                        <option value="{{ $activeHome->id }}">{{ $activeHome->location }}</option>
                      @endif
                    @endforeach
                </select>
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
                <input type="real" class="form-control" id="price" name="price" placeholder="Ingrese el precio en $" value="{{ old('price') }}">
                @if($errors->has('price'))
                  <div class="fallo horizontal-list">
                    {{ $errors->first('price') }}
                  </div>
                @endif
              </div>
              <br>
              <div class="links horizontal-list">
                <button type="submit" class="btn btn-primary">Crear</button>
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

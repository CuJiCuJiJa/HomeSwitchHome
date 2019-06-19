@extends('layouts.app')

@section('content')


<div class="container mask-white">
  <div class="row">
    <div class="col-12">

      <div class="card">
        <div class="card-header">Crear Subasta</div>
          <div class="card-body">

            <form action="{{ route('auction.store') }}" method="POST">
              {{ csrf_field() }}
              
              <?php         
                $date = \Carbon\Carbon::now()->addMonths(6);
                if (!$date->isMonday()){
                  $date = $date->startOfWeek();
                }                               
                $date = $date->format('Y-m-d');
              ?>

              <div class='form-group'>
                <label for="weekAuctioned">Semana a subastar</label>
                <br>
                <input type="date" name="weekAuctioned" id="weekAuctioned" min="{{$date}}" value="{{ old('weekAuctioned') }}"> <br>
                @if($errors->has('weekAuctioned'))
                  <div class="fallo horizontal-list">  
                    {{ $errors->first('weekAuctioned') }}
                  </div>
                @endif
              </div>

              <div class='form-group'>
                <label for="starting_date">Fecha de inicio</label>
                <br>
                <input type="text"  class="form-control" name="starting_date" id="starting_date" value="{{ old('starting_date') }}" readonly/>
                @if($errors->has('starting_date'))
                  <div class="fallo horizontal-list">  
                    {{ $errors->first('starting_date') }}
                  </div>
                @endif
              </div>

              <script>
               
                $('#weekAuctioned').change(function() {
                  var month = parseInt($(this).val().substring(5, 7));
                  var year = parseInt($(this).val().substring(0, 4));
                  if (month > 6 ){
                    month = (month - 6);
                    month = '0' + month;
                  } else {
                    if (month < 4 ){
                      month = '0' + (month + 6);                      
                    } else {
                      month = (month + 6);                                          
                    }
                    year = (year - 1);
                  }   

                  var auctionDate = month + '/' + $(this).val().substring(8, 10) +'/' + year;
                  console.log(auctionDate);
                  $('#starting_date').val(auctionDate);
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
                @if(session('sameAuction'))
                  <div class="fallo horizontal-list">
                    {{ session('sameAuction') }}
                  </div>
                @endif
              </div>
              
              
              <div class="form-group">
                <label for="base_price">Monto base</label>
                <input type="real" class="form-control" id="base_price" name="base_price" placeholder="Ingrese el monto base en $" value="{{ old('base_price') }}">
                @if($errors->has('base_price'))
                  <div class="fallo horizontal-list">  
                    {{ $errors->first('base_price') }}
                  </div>
                @endif
              </div>

              <br>
              
              <div class="links horizontal-list">
                 <button type="submit" class="btn btn-primary">Crear</button>
              
                 <a href="{{ route('auction.index') }}">Cancelar</a>
              </div>

            </form>

          </div>
        </div>
      </div>

    </div>
  </div>
</div>
@endsection

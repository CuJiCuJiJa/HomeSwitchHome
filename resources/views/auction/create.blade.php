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
              

              <div class='form-group'>
                <label for="weekAuctioned">Semana subastada</label>
                <br>
                <input type="date" data-date="" data-date-format="DD MMMM YYYY" name="weekAuctioned" id="weekAuctioned">
              </div>

              <div class='form-group'>
                <label for="starting_date">Fecha de inicio</label>
                <br>
                <input type="text"  class="form-control" name="starting_date" id="starting_date" readonly/>
                @if($errors->has('starting_date'))
                  {{ $errors->first('starting_date') }}
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
                      <option value="{{ $activeHome->id }}">{{ $activeHome->location }}</option>
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
                <input type="real" class="form-control" id="base_price" name="base_price" placeholder="Ingrese el monto base en $" value="{{ old('base_price') }}">
                @if($errors->has('base_price'))
                  {{ $errors->first('base_price') }}
                @endif
              </div>

              <br>
              
              <button type="submit" class="btn btn-primary">Crear</button>
              
              <a href="{{ URL::previous() }}">Cancelar</a>
            </form>
          </div>
        </div>
      </div>
    </div>
  </div>
</div>
@endsection

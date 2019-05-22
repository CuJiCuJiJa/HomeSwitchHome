@extends('layouts.app')

@section('content')
<div class="container">

    <div class="row">

        <div class="col-12">

            <div class="card">
                <div class="card-header">Crear Subasta</div>
                <div class="card-body">
                    <form action="{{ route('auction.store') }}" method="POST">
                      {{ csrf_field() }}

                    <div class='form-group'>
                          
                          <label for="week">Semana subastada</label>
                          <br>
                          <input type="text" name="week" id="week">
                          
                          <script>
                            $( "#week" ).weekpicker().on('change.weekpicker', function(a){
                              var picker = $(a.target).data('weekpicker');

                            })                              
                          </script>

                          <script>
                            function getDateOfWeek(w, y) {
                              var d = (1 + (w - 1) * 7); // 1st of January + 7 days for each week
                              return new Date(y, 0, d);
                            }
                          </script>
                      </div>
<script>
  $('input[name=product]').val(product);
</script>
                      <div class="form-group">
                        <label for="starting_date">Fecha de inicio</label>
                        <input type="date" class="form-control" id="starting_date" name='starting_date' value="{{ old('starting_date') }}">
                        @if($errors->has('starting_date'))
                          {{ $errors->first('starting_date') }}
                      @endif
                      </div>
                      

                      <div class="form-group">
                        <label for="home_id">Residencia</label>
                        <select class="form-control" id="home_id" name="home_id">
                          <option value="">Seleccione una residencia</option>
                          @foreach($activeHomes as $activeHome)
                            <option value="{{ $activeHome->id }}">Residencia: {{ $activeHome->id }}, de: {{ $activeHome->location }}</option>
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
                      <button type="submit" class="btn btn-primary">Submit</button>
                      <a href="{{ URL::previous() }}">Cancelar</a>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@extends('layouts.app')

@section('content')


<div class="container mask-white">
  <div class="row">
    <div class="col-12">
        

      <div class="card">
        <div class="card-header">Reservar</div>
        @if (session('status'))
            <div class="alert alert-success" role="alert">
                {{ session('status') }}
            </div>
        @endif
          <div class="card-body">
            @if(session('error'))
                    <div class="fallo horizontal-list">
                        {{ session('error') }}
                    </div>
                @endif
            @if(session('success'))
                <div class="exito horizontal-list">
                    {{ session('success') }}
                </div>
             @endif
            <form action="{{ route('reservation.store'), $home->id }}" method="POST">
              {{ csrf_field() }}
              
              <?php         
                $date = \Carbon\Carbon::now()->addMonths(6);
                if (!$date->isMonday()){
                  $date = $date->addWeek()->startOfWeek();
                }     
                $maxDate = \Carbon\Carbon::now()->addMonths(12)->subWeek()->format('Y-m-d');                       
                $date = $date->format('Y-m-d');
              ?>

              <div class='form-group'>
                <label for="weekToReserve">Seleccionar semana</label>
                <br>
                <input type="date" name="weekToReserve" id="weekToReserve" min="{{$date}}" max="{{$maxDate}}" value="{{ $week }}"> <br>
                @if($errors->has('weekToReserve'))
                  <div class="fallo horizontal-list">  
                    {{ $errors->first('weekToReserve') }}
                  </div>
                @endif
              </div>
            
            <div class="form-group">
                <label for="home_id">Residencia</label>
                <select class="form-control" id="home_id" name="home_id">

                        <option value="{{ $home->id }}" selected>{{ $home->location }}</option>
                </select>
               
                <div class="descripcion"> 
               Ubicación: {{ $home->location }}
               <br>
               Descripción: {{  $home->descrip }}
        
               <br>
               </div>

                @if($errors->has('home_id'))
                  <div class="fallo horizontal-list">  
                    {{ $errors->first('home_id') }}
                </div>  
                @endif
              </div>         

              <br>
              
              <div class="links horizontal-list">
                 <button type="submit" class="btn btn-primary">Reservar</button>
              
                 <a href="/getSearchReserve">Cancelar</a>
              </div>

            </form>

          </div>
        </div>
      </div>

    </div>
  </div>
</div>
@endsection

@extends('layouts.app')

@section('content')

<div class="container mask-white">
    <div class="row justify-content-center">
        <div class="col-12">
            <div class="card">

                <div class="card-header">Buscar residencias disponibles </div>

                <div class="card-body">

                    <form action="{{ route('postSearch.reserve') }}" method="POST">
                        {{ csrf_field() }}

                        <div class="form-group">
                            <label for="fromDate">Inicio de busqueda:</label>
                            <input type="text" class="form-control" id="fromDate"  name="fromDate" placeholder="Ingresar semana" required>
                                @if ($errors->has('fromDate'))
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $errors->first('fromDate') }}</strong>
                                    </span>
                                @endif
                        </div>

                        <div class="form-group">
                            <label for="toDate">Fin de busqueda:</label>
                            <input type="text" class="form-control" id="toDate"  name="toDate"  placeholder="Ingresar semana" required>
                                @if ($errors->has('toDate'))
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $errors->first('toDate') }}</strong>
                                    </span>
                                @endif
                        </div>

                        <div class="form-group">
                            <label for="location">Localidad:</label>
                            <input type="text" class="form-control" id="location" name='location' placeholder="Ubicación">
                        </div>
                        <div class="links horizontal-list">
                            <button type="submit" class="btn btn-primary">Buscar</button>
                        </div>
                    </form>

                    <div class="links horizontal-list">
                        <a href="{{ URL::previous() }}">Cancelar</a>
                    </div>

                </div>
            </div>
        </div>
    </div>
</div>

@endsection

@section('footer')
  <script>
  $(function() {
    $( "#fromDate" ).datepicker({
        changeMonth: true,
        minDate: "+6m",
        maxDate: "+10m",
        onSelect: function(date){
            //Setea el min y max de el fin de busqueda

            var min = $("#fromDate").datepicker("getDate");
            var max = new Date(min.getTime());

            max.setMonth(max.getMonth() + 2);
            $("#toDate").datepicker( "option", { minDate:min, maxDate:max});
    } });

    $( "#toDate" ).datepicker({
        changeMonth: true,
    });
  });

  </script>

@endsection



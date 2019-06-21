@extends('layouts.app')


@section('content')

<div class="container mask-white">
    <div class="row justify-content-center">
        <div class="col-12">
            <div class="card">

                <div class="card-header">Buscar Subasta</div>

                <div class="card-body">

                    <form action="{{ route('postSearch.home') }}" method="POST">
                        {{ csrf_field() }}
                        
                        <div class="form-group">
                            <label for="fromDate">Inicio de busqueda:</label>
                            <input type="text" class="form-control" id="fromDate"  name="fromDate" placeholder="Ingresar semana">
                        </div>

                        <div class="form-group">
                            <label for="toDate">Fin de busqueda:</label>
                            <input type="text" class="form-control" id="toDate"  name="toDate"  placeholder="Ingresar semana">
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
                        <a href="{{ route('reservation.index') }}">Cancelar</a>  
                    </div>

                </div>
            </div>
        </div>
    </div>
</div>

@endsection

@section('footer')
<script src="//code.jquery.com/jquery-1.10.2.js"></script>
  <script src="//code.jquery.com/ui/1.11.2/jquery-ui.js"></script>
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



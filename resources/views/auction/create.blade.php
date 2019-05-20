@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">Crear Subasta</div>
                <div class="card-body">
                    <form action="{{ route('auction.store') }}" method="POST">
                      {{ csrf_field() }}
                      <div class="form-group">
                        <label for="week">Semana:</label>
                        <input type="number" class="form-control" id="week" name="week" placeholder="Ingresar semana">
                      </div>
                      <div class="form-group">
                        <label for="starting_date">Fecha de inicio</label>
                        <input type="date" class="form-control" id="starting_date" name='starting_date' placeholder="Fecha de inicio">
                      </div>
                      <div class="form-group">
                        <label for="year">Año</label>
                        <input type="number" class="form-control" id="year" name="year" placeholder="Año de la subasta">
                      </div>
                      <div class="form-group">
                        <label for="base_price">Monto inicial</label>
                        <input type="real" class="form-control" id="base_price" name="base_price" placeholder="Monto inicial">
                      </div>
                      <button type="submit" class="btn btn-primary">Submit</button>
                      <a href="{{ URL::previous() }}">Cancelar</a>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

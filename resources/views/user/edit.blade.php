    @extends('layouts.app')

@section('content')
<div class="container mask-white">
    <div class="row justify-content-center">
        <div class="col-12">

            @if(session('success'))
                <div class="exito horizontal-list">
                    {{ session('success') }}
                </div>
            @endif
            <div class="card">

                <div class="card-header"> Mi información </div>

                <div class="card-body">

                    @if (session('status'))
                        <div class="alert alert-success" role="alert">
                            {{ session('status') }}
                        </div>
                    @endif

                    <form action="{{ route('user.update', $user->id) }}" method="POST">

                        {{ csrf_field() }}
                        {{ method_field('PUT') }}
                        <div class="descripcion">
                        <div class="form-group">
                            <label for="email">email</label>
                            <input type="text" class="form-control" id="email" name="email" placeholder="Ingresar email" value="{{ $user->email }}" >

                            <span>
                                @if($errors->has('email'))
                                  {{ $errors->first('email') }}
                                @endif
                            </span>

                        </div>

                        <div class="form-group">
                                <label for="name">nombre</label>
                                <input type="text" class="form-control" id="card" name='card' placeholder="Ingresar un nombre" value="{{ $user->name }}">
                        </div>

                        <div class="form-group">
                                <label for="número de tarjeta">número de tarjeta</label>
                                <input type="text" class="form-control" id="card" name='card' placeholder="Ingresar una número de tarjeta" value="{{ $user->card_number }}">
                        </div>

                        {{-- <div class="form-group">
                                <label for="password" >{{ __('Contraseña') }}</label>

                                <div >
                                <input id="password" type="password" class="form-control{{ $errors->has('password') ? ' is-invalid' : '' }}" name="password" value="{{$user->password}}" required>

                                    @if ($errors->has('password'))
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $errors->first('password') }}</strong>
                                        </span>
                                    @endif
                                </div>
                        </div>

                        <div class="form-group">
                                <label for="password-confirm" >{{ __('Confirmar contraseña') }}</label>

                                <div >
                                    <input id="password-confirm" type="password" class="form-control" name="password_confirmation" required>
                                </div>
                        </div> --}}


                        <div class="links horizontal-list">
                            <button type="submit" class="btn btn-primary">Confirmar</button>

                        </div>
</div>

                    </form>

                </div>

            </div>

        </div>
    </div>
</div>
@endsection

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
                        {{ method_field('PATCH') }}
                        <div class="descripcion">
                            <div class="form-group">
                                <label for="email">email</label>
                                <input type="text" class="form-control" id="email" name="email" placeholder="Ingresar email" value="{{ $user->email }}" required >

                                <span>
                                    @if($errors->has('email'))
                                    {{ $errors->first('email') }}
                                    @endif
                                </span>

                            </div>

                            <div class="form-group">
                                    <label for="name">nombre</label>
                                    <input type="text" class="form-control" id="name" name='name' placeholder="Ingresar un nombre" value="{{ $user->name }}" required>
                            </div>
                            <span>
                                @if($errors->has('name'))
                                {{ $errors->first('name') }}
                                @endif
                            </span>

                            <div class="form-group">
                                <label for="birthdate">Fecha de Nacimiento</label>
                                <input type="date" class="form-control" id="birthdate" name='birthdate' value="{{ $user->birthdate }}" required>
                                <span>
                                    @if($errors->has('birthdate'))
                                    {{ $errors->first('birthdate') }}
                                    @endif
                                </span>

                            </div>

                            <div class="form-group">
                                    <label for="número de tarjeta">número de tarjeta</label>
                                    <input type="text" class="form-control" minlength="16" maxlength="16" id="card" name='card' placeholder="Ingresar una número de tarjeta" value="{{ $user->card_number }}">
                                    <span>
                                        @if($errors->has('card'))
                                        {{ $errors->first('card') }}
                                        @endif
                                    </span>

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

                    <form action="{{route('user.destroy', $user->id)}}" method="post">
                        {{method_field('DELETE')}}
                        {{csrf_field()}}
                        <button class="btn btn-danger" type="submit" onclick="return confirm('¿Desea dar de baja su cuenta de usuario?');">Dar de baja cuenta</button>
                    </form>

                    <a href="{{route('getchangePassword')}}">Cambiar contraseña</a>

                </div>
            </div>
        </div>
    </div>
</div>
@endsection

<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>

    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <!-- favicon -->
    <link rel="icon" type="image/svg" href="{{ asset('HSH-Logo.svg')}}" sizes="16x16" >
    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>Home switch home</title>
    <!-- Scripts -->
    <script src="{{ asset('js/app.js') }}" defer></script>
    <!-- Fonts -->
    <link rel="dns-prefetch" href="//fonts.gstatic.com">
    <link href="https://fonts.googleapis.com/css?family=Nunito:200,600" rel="stylesheet">
    <!-- Styles -->
    <link href="{{ asset('css/stylehsh.css') }}" rel="stylesheet"> 
    <link href="{{ asset('css/app.css') }}" rel="stylesheet">

    @yield('head')

    <link rel="stylesheet" href="{{asset('js/jquery-ui.min.css')}}">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.4.0/jquery.min.js"></script>
    <script src="{{asset('js/jquery-ui.min.js')}}"></script>
    <script src="{{asset('js/jquery.weekpicker.js')}}"></script>
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.5/css/bootstrap.min.css">
</head>

<!--?php
    $bg = array('fondo2.jpg','fondo3.jpg','fondo4.jpg' ); // array of filenames
    $i = rand(0, count($bg)-1); // generate random number size of the array
    $selectedBg = "$bg[$i]"; // set variable equal to which random filename was chosen
?-->

<body  style="background: url({{asset('fondo3.jpg')}}) right">
    <header id="app">
        <nav class="navbar navbar-expand-md navbar-light navbar-laravel">
            <div class="container">
                <a class="navbar-brand" href="{{ url('/') }}">
                    Inicio
                </a>
                    

                <!-- Menu sanguchito mobile -->
                <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="{{ __('Toggle navigation') }}">
                    <span class="navbar-toggler-icon"></span>
                </button>

                
                    <!-- Menu a la izquierda -->
                    <ul class="navbar-nav mr-auto">
                    </ul>

                    <!-- Menu a la derecha-->
                    <div class="col-4">
                    <ul class="navbar-nav ml-auto">
                        <!-- ¿hay iniciada una sesion? -->
                        @guest
                            <!-- hay iniciada una sesion -->
                            <li class="nav-item">
                                <a class="nav-link" href="{{ route('login') }}">{{ __('Iniciar sesión') }}</a>
                            </li>
                            @if (Route::has('register'))
                                <li class="nav-item">
                                    <a class="nav-link" href="{{ route('register') }}">{{ __('Registrarse') }}</a>
                                </li>
                            @endif
                        @else
                        <div class="collapse navbar-collapse" id="navbarSupportedContent">
                        <div class="nav-item dropdown">
    
    <a class="nav-link dropdown-toggle dropdown-toggle" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" v-pre>
        {{ Auth::user()->name }}
        </button>
    </a>

    <ul class="dropdown-menu " aria-labelledby="navbarDropdown">
 
        <li class="dropdown-submenu ">
            <a class="test dropdown-toggle dropdown-item" role="button" aria-haspopup="true" tabindex="-1" href="#"> 
                Subastas 
                
            </a>
            <ul class="dropdown-menu second" aria-labelledby="navbarDropdown">
                <li><a class="dropdown-item" tabindex="-1" href="#">2nd level dropdown</a></li>
                <li><a class="dropdown-item" tabindex="-1" href="#">2nd level dropdown</a></li>
                <li><a class="dropdown-item" tabindex="-1" href="#">Another dropdown </a>
                </li>
            </ul>
        </li>

        <li class="dropdown-submenu ">
            <a class="test dropdown-toggle dropdown-item" role="button" aria-haspopup="true" tabindex="-1" href="#"> 
                Residencias 
                
            </a>
            <ul class="dropdown-menu second" aria-labelledby="navbarDropdown">
                <li><a class="dropdown-item" tabindex="-1" href="#">reci</a></li>
                <li><a class="dropdown-item" tabindex="-1" href="#">o resi</a></li>
                <li><a class="dropdown-item" tabindex="-1" href="#">dencias</a>
                </li>
            </ul>
        </li>



        <a class="dropdown-item" href="{{ route('logout') }}"
        onclick="event.preventDefault();
        document.getElementById('logout-form').submit();">
            {{ __('Cerrar sesión') }}
        </a>

        <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
            @csrf
        </form>
    </ul>
  </div>
</div>
</div>
<script>
$(document).ready(function(){
  $('.dropdown-submenu a.test').on("click", function(e){
    if (('.second').is(':visible')){
      $('.second').hide();
    }
    else{
    $(this).next('ul').toggle();
    e.stopPropagation();
    e.preventDefault();
    }
  });
});
</script>


                        @endguest
                    </ul>
                    </div>

                </div>


            
        </nav>
    </header>

    <main class="py-4">
        @yield('content')
    </main>
</body>
<footer>

    @yield('footer')

</footer>
</body>
</html>
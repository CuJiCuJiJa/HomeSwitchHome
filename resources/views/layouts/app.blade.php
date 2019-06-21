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

    <!-- Fonts -->
    <link rel="dns-prefetch" href="//fonts.gstatic.com">
    <link href="https://fonts.googleapis.com/css?family=Nunito:200,600" rel="stylesheet">
    <!-- Styles -->
    <link href="{{ asset('css/stylehsh.css') }}" rel="stylesheet"> 
    <link href="{{ asset('css/app.css') }}" rel="stylesheet">

    @yield('head')
    <script  src="https://code.jquery.com/jquery-3.3.1.min.js" integrity="sha256-FgpCb/KJQlLNfOu91ta32o/NMZxltwRo8QtmkMRdAu8=" crossorigin="anonymous"></script>
    <link rel="stylesheet" href="//code.jquery.com/ui/1.11.2/themes/smoothness/jquery-ui.css">

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
                                </a>
                                <ul class="dropdown-menu " aria-labelledby="navbarDropdown">
                               
                                @if (!Auth::user()->isAdmin())
                                   <li class="dropdown-submenu ">
                                        <a class="test dropdown-toggle dropdown-item" role="button" aria-haspopup="true" tabindex="-1" href="#"> 
                                            Subastas 
                                        </a>
                                        <ul class="dropdown-menu second" aria-labelledby="navbarDropdown">
                                            <li>
                                                <a class="dropdown-item" tabindex="-1" href="/getSearchAuction">Buscar subastas</a>
                                            </li>
                                            <li>
                                                <a class="dropdown-item" tabindex="-1" href="/auction">Mis subastas</a>
                                            </li>
                                        </ul>
                                    </li>
                                                                     

                                    <li class="dropdown-submenu ">
                                        <a class="test dropdown-toggle dropdown-item" role="button" aria-haspopup="true" tabindex="-1" href="#"> 
                                            Reservas
                                        </a>
                                        <ul class="dropdown-menu second" aria-labelledby="navbarDropdown">
                                            <li>
                                                <a class="dropdown-item" tabindex="-1" href="/getSearchReserve">Buscar</a>
                                            </li>
                                            <li>
                                                <a class="dropdown-item" tabindex="-1" href="#">Mis reservas</a>
                                            </li>
                                        </ul>
                                    </li>
                                    
                                   
                                    <li class="dropdown-submenu ">
                                        <a class="test dropdown-toggle dropdown-item" role="button" aria-haspopup="true" tabindex="-1" href="#"> 
                                            Hotsales 
                                        </a>
                                        <ul class="dropdown-menu second" aria-labelledby="navbarDropdown">
                                            <li>
                                                <a class="dropdown-item" tabindex="-1" href="">Buscar hotsales</a>
                                            </li>
                                            <li>
                                                <a class="dropdown-item" tabindex="-1" href="#">Mis hotsales</a>
                                            </li>
                                        </ul>
                                    </li>    
                                                            
                                @else

                                    <li class="dropdown-submenu ">
                                        <a class="test dropdown-toggle dropdown-item" role="button" aria-haspopup="true" tabindex="-1" href="#"> 
                                            Subastas 
                                        </a>
                                        <ul class="dropdown-menu second" aria-labelledby="navbarDropdown">
                                            <li>
                                                <a class="dropdown-item" tabindex="-1" href="/auction/create">Crear subasta</a>
                                            </li>
                                            <li>
                                                <a class="dropdown-item" tabindex="-1" href="/auction">Listar subasta</a>
                                            </li>
                                        </ul>
                                    </li>
                                    
                                    <li class="dropdown-submenu ">
                                        <a class="test dropdown-toggle dropdown-item" role="button" aria-haspopup="true" tabindex="-1" href="#"> 
                                            Residencias 
                                        </a>
                                        <ul class="dropdown-menu second" aria-labelledby="navbarDropdown">
                                            <li>
                                                <a class="dropdown-item" tabindex="-1" href="/home/create">Dar de alta residencia</a>
                                            </li>
                                            <li>
                                                <a class="dropdown-item" tabindex="-1" href="home">Listar residencias</a>
                                            </li>
                                        </ul>
                                    </li>

                                    <li class="dropdown-submenu ">
                                        <a class="test dropdown-toggle dropdown-item" role="button" aria-haspopup="true" tabindex="-1" href="#"> 
                                            Hotsales 
                                        </a>
                                        <ul class="dropdown-menu second" aria-labelledby="navbarDropdown">
                                            <li>
                                                <a class="dropdown-item" tabindex="-1" href="#">Crear hotsale</a>
                                            </li>
                                            <li>
                                                <a class="dropdown-item" tabindex="-1" href="#">Listar hotsales</a>
                                            </li>
                                        </ul>
                                    </li>    


                                @endif


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
                                $(this).next('.second').slideToggle('slow');
                                e.stopPropagation();
                                e.preventDefault();
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
</html>
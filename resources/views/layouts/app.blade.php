<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'Laravel') }}</title>

    <!-- Scripts -->
    <script src="{{ asset('js/app.js') }}" defer></script>

    <!-- Fonts -->
    <link rel="dns-prefetch" href="//fonts.gstatic.com">
    <link href="https://fonts.googleapis.com/css?family=Nunito" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">

    <!-- Styles -->
    <link href="{{ asset('css/app.css') }}" rel="stylesheet">
    <link href="{{ asset('css/crearTipoDeEvento.css') }}" rel="stylesheet">
    <link href="{{ asset('css/crearEvento.css') }}" rel="stylesheet">
</head>

<body>
    <div id="app">
        <nav class="navbar navbar-expand-md navbar-light bg-white shadow-sm">
            <div class="container">
                <a class="navbar-brand" href="{{ url('/') }}">
                    <img src="https://foundation.icpc.global/wp-content/uploads/2023/05/2023-icpc-foundation-logo-3c@300.png" class="img" alt="logo_pagina" width="100">
                </a>
                <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="{{ __('Toggle navigation') }}">
                    <span class="navbar-toggler-icon"></span>
                </button>

                <div class="collapse navbar-collapse" id="navbarSupportedContent">
                    <!-- Left Side Of Navbar -->
                    <ul class="navbar-nav me-auto">
                        <!-- Authentication Links -->
                        @guest
                        @if (Route::has('login'))
                        <li class="nav-item">
                            <a class="nav-link" href="{{ url('/eventos') }}">{{ __('Eventos') }}</a>
                        </li>
                        @endif
                        @endguest
                    </ul>

                    <!-- Right Side Of Navbar -->
                    <ul class="navbar-nav ms-auto">

                    </ul>
                </div>
            </div>
        </nav>

        <main class="py-4">
            @yield('content')
        </main>

        <footer class="bg-light">
            <hr class="hr" />
            <div class="container">
                <div class="row align-items-center">
                    <div class="col-1">
                        <a href="https://www.umss.edu.bo/" target="_blank">
                            <img src="{{URL::asset('/image/logo-umss.png')}}" class="img" alt="logo_umss" width="125">
                        </a>
                    </div>
                    <div class="col-10 text-secondary text-center">
                        <p>
                            © 2023 - CBBA
                        </p>
                    </div>
                    <div class="col-1">
                        <a href="https://www.cs.umss.edu.bo/" target="_blank">
                            <img src="{{URL::asset('/image/logo-departamento.png')}}" class="img" alt="logo_departamento" width="45">
                        </a>
                    </div>
                </div>
            </div>
        </footer>

    </div>

</body>

</html>
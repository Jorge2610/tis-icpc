<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'ICPC - UMSS') }}</title>

    <!-- Scripts -->
    <script src="{{ asset('js/app.js') }}" defer></script>
    <script src="{{ asset('js/alerta.js') }}" defer></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.7.1/jquery.min.js"></script>
    <script src="https://cdn.datatables.net/1.13.6/js/jquery.dataTables.min.js"></script>

    <script src="{{ asset('js/layout.js') }}" defer></script>
    <!-- Fonts -->
    <link rel="dns-prefetch" href="//fonts.gstatic.com">
    <link href="https://fonts.googleapis.com/css?family=Nunito" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.2/css/all.min.css">

    <!-- Styles -->
    <link href="{{ asset('css/app.css') }}" rel="stylesheet">
    <link href="{{ asset('css/crearTipoDeEvento.css') }}" rel="stylesheet">
    <link href="{{ asset('css/crearEvento.css') }}" rel="stylesheet">
    <link href="{{ asset('css/tipoEvento.css') }}" rel="stylesheet">
    <link href="{{ asset('css/eventos.css') }}" rel="stylesheet">
    <link href="{{ asset('css/mostrar-evento.css') }}" rel="stylesheet">
    <link href="{{ asset('css/layout.css') }}" rel="stylesheet">
    <link href="{{ asset('css/patrocinador.css') }}" rel="stylesheet">
</head>

<body>
    <div id="app">
        <div id="alertsContainer" class="customAlertContainer"></div>
        <header>
            <!-- Navbar -->
            <nav id="main-navbar" class="navbar navbar-expand-lg navbar-light bg-white fixed-top shadow-sm"
                style="height: 12vh">
                <!-- Container wrapper -->
                <div class="container-fluid d-flex align-middle">

                    <!-- Toggle button -->
                    <button class="navbar-toggler" type="button" data-bs-toggle="collapse"
                        data-bs-target="#sidebarMenu" aria-controls="sidebarMenu" aria-expanded="false"
                        aria-label="{{ __('Toggle navigation') }}">
                        <i class="fas fa-bars"></i>
                    </button>

                    <div class="ms-3" style="height: 10vh">
                        <!-- Brand -->
                        <a class="navbar-brand" href="{{ url('/') }}">
                            <img class="img"
                                src="https://foundation.icpc.global/wp-content/uploads/2023/05/2023-icpc-foundation-logo-3c@300.png"
                                alt="logo_pagina" loading="lazy" style="height: 100%" />
                        </a>
                    </div>

                    <!-- Left Side Of Navbar -->
                    <ul class="navbar-nav me-auto d-flex flex-row">
                        <a class="nav-link mt-3" href="{{ url('/eventos') }}" id="eventosNav">
                            <h4>Eventos</h4>
                        </a>
                    </ul>

                    <!-- Right links -->
                    <ul class="navbar-nav ms-auto d-flex flex-row">

                    </ul>
                </div>
                <!-- Container wrapper -->
            </nav>
            <!-- Navbar -->
            <!-- Sidebar -->
            <nav id="sidebarMenu" class="collapse d-lg-block sidebar collapse bg-white">
                <div class="position-sticky">
                    <div class="list-group list-group-flush mx-1 mt-3">
                        <div class="accordion" id="menuLateral">
                            <x-sider.tipo-evento />
                            <x-sider.evento />
                            <x-sider.actividad />
                            <x-sider.afiche />
                            <x-sider.patrocinador />
                            <x-sider.sitios-interes />
                        </div>
                    </div>
                </div>
            </nav>
            <!-- Sidebar -->
        </header>

        <main style="margin-top: 14vh">
            <div class="border-start border-2" style="min-height: 77vh;">
                @yield('content')
            </div>
        </main>

        <footer class="bg-light border-top mt-2" style="margin-top: auto;">
            <div class="col-md-12 d-flex align-items-center">
                <div class="col-md-1">
                    <a class="ms-5" href="https://www.umss.edu.bo/" target="_blank">
                        <img src="{{ URL::asset('/image/logo-umss.png') }}" class="img" alt="logo_umss"
                            width="125">
                    </a>
                </div>
                <div class="col-md-10 text-secondary text-center">
                    <h6>© 2023 - CBBA</h6>
                </div>
                <div class="col-md-1">
                    <a class="ms-4" href="https://www.cs.umss.edu.bo/" target="_blank">
                        <img src="{{ URL::asset('/image/logo-departamento.png') }}" class="img"
                            alt="logo_departamento" width="45">
                    </a>
                </div>
            </div>
        </footer>

    </div>
</body>

</html>

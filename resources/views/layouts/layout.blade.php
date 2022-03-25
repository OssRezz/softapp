<!doctype html>
<html lang="en">

<head>
    <link rel="icon" href="{{ asset('img/ico.png') }}" />
    <meta name="csrf-token" content="{{ csrf_token() }}" />
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />

    <!-- Jquery -->
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>

    <!-- {{-- Animted Css --}} -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/animate.css/4.1.1/animate.min.css" />

    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet" />

    <!-- Datatables-->
    <link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/1.11.4/css/jquery.dataTables.min.css" />
    <script type="text/javascript" src="https://cdn.datatables.net/1.11.4/js/jquery.dataTables.min.js"></script>

    <!-- {{-- calendar --}} -->
    <script src="https://cdn.jsdelivr.net/npm/fullcalendar@5.10.2/main.js"></script>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/fullcalendar@5.10.2/main.css" />
    <script src="https://cdn.jsdelivr.net/npm/fullcalendar@5.10.2/locales-all.js"></script>


    <link rel="stylesheet" href="{{ asset('css/style.css') }}" />
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.1.0/css/all.min.css" />
    <title>@yield('title')</title>
</head>

<body class="bg-light">
    <div id="response"></div>
    <div class="loader-page"></div>

    <div class="container-fluid">
        <div class="row mb-4">
            <div class="col p-0">
                <nav
                    class="navbar navbar-expand-lg navbar-white bg-white border-md border-bottom  d-flex justify-content-end py-2">
                    <div class="container-fluid">
                        <a class="navbar-brand  pe-3 border-end" href="#"><b>SoftApp</b></a>
                        <button class="navbar-toggler btn btn-outline-primary  border-0" type="button"
                            data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent"
                            aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
                            <i class="fas fa-bars"></i>
                        </button>
                        <div class="collapse navbar-collapse" id="navbarSupportedContent">
                            <ul class="navbar-nav me-auto mb-2 mb-lg-0">
                                <li class="nav-item px-1">
                                    <a class="btn btn-outline-primary border-0 {{ Request::is('/') ? 'active' : '' }}"
                                        href="{{ url('/') }}"><i class="fas fa-home"></i> Inicio</a>
                                </li>
                                <li class="nav-item px-1">
                                    <a class="btn btn-outline-primary border-0 {{ Request::is('clientes') ? 'active' : '' }}"
                                        href="{{ url('clientes') }}"><i class="fas fa-user"></i> Clientes</a>
                                </li>
                                <li class="nav-item px-1">
                                    <a class="btn btn-outline-primary border-0 {{ Request::is('servicios') ? 'active' : '' }}"
                                        href="{{ url('servicios') }}"><i class="fas fa-server"></i> Servicios</a>
                                </li>
                            </ul>
                            <div class="dropdown px-1">
                                <button class="btn btn-outline-dark border-0 dropdown-toggle" type="button"
                                    id="dropOutCard" data-bs-toggle="dropdown"
                                    aria-expanded="false">{{ Auth::user()->name }}
                                </button>
                                <ul class="dropdown-menu dropdown-menu-dark dropdown-menu-end"
                                    aria-labelledby="dropOutCard">
                                    <li>
                                        <form action="login/logout" method="POST">
                                            @csrf
                                            <a class="dropdown-item text-primary text-white" href="#"
                                                onclick="this.closest('form').submit()" id="btn-salir">Cerrar
                                                sesion <i class="fas fa-sign-out-alt"></i></a>
                                        </form>
                                    </li>
                                </ul>
                            </div>
                        </div>
                    </div>
                </nav>
            </div>
        </div>
    </div>

    <div class="container-fluid mb-3">
        @yield('content')

    </div>


    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js"></script>
    <script src="{{ asset('js/spinner.js') }}"></script>
</body>

</html>

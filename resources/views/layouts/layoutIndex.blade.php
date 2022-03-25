<!doctype html>
<html lang="en">

<head>
    <link rel="icon" href="{{ asset('img/ico.png') }}" />
    <meta name="csrf-token" content="{{ csrf_token() }}" />
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

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
                    <div class="container-fluid d-flex justify-content-strech">
                        <a class="navbar-brand  pe-3 border-end" href="#"><b>SoftApp</b></a>
                        <a href="{{ route('login') }}" class="btn btn-outline-primary" type="button">
                            Iniciar sesion <i class="fas fa-sign-in"></i>
                        </a>
                    </div>
                </nav>
            </div>
        </div>
    </div>

    @yield('content')


    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js"></script>
    <script src="{{ asset('js/spinner.js') }}"></script>
</body>

</html>

<!DOCTYPE html>
<html lang="es">

<head>

    <meta charset="UTF-8">

    <meta name="viewport"
          content="width=device-width, initial-scale=1.0">

    <title>@yield('title')</title>

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css"
          rel="stylesheet">

    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

</head>

<body class="bg-light">

    <nav class="navbar navbar-expand-lg navbar-dark bg-dark">

        <div class="container">

            <a class="navbar-brand"
               href="#">

                Barbería App

            </a>

            <div class="d-flex gap-2">

                @auth

                    @if(auth()->user()->role == 'admin')

                        <a href="{{ route('dashboard.admin') }}"
                           class="btn btn-outline-light btn-sm">

                            Dashboard

                        </a>

                        <a href="{{ route('servicios.index') }}"
                           class="btn btn-outline-light btn-sm">

                            Servicios

                        </a>

                        <a href="{{ route('horarios.index') }}"
                           class="btn btn-outline-light btn-sm">

                            Horarios

                        </a>

                    @endif

                    <a href="{{ route('reservas.index') }}"
                       class="btn btn-outline-light btn-sm">

                        Reservas

                    </a>

                    <form action="{{ route('logout') }}"
                          method="POST">

                        @csrf

                        <button class="btn btn-danger btn-sm">

                            Logout

                        </button>

                    </form>

                @endauth

            </div>

        </div>

    </nav>

    <div class="container py-5">

        @yield('content')

    </div>

    @yield('scripts')

</body>

</html>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Reservas</title>

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
</head>

<body class="bg-light">

<div class="container py-5">

    <div class="card shadow-sm">

        <div class="card-body">

            <div class="d-flex justify-content-between align-items-center mb-4">

                <h1 class="h3 mb-0">
                    Reservas
                </h1>

                <a href="{{ route('reservas.create') }}"
                   class="btn btn-primary">

                    Crear reserva

                </a>

            </div>

            @if(session('success'))

                <div class="alert alert-success">

                    {{ session('success') }}

                </div>

            @endif

            <table class="table table-bordered table-hover">

                <thead class="table-dark">

                    <tr>

                        <th>ID</th>
                        <th>Cliente</th>
                        <th>Servicio</th>
                        <th>Fecha</th>
                        <th>Hora</th>
                        <th>Estado</th>

                    </tr>

                </thead>

                <tbody>

                    @forelse($reservas as $reserva)

                        <tr>

                            <td>{{ $reserva->id }}</td>

                            <td>
                                {{ $reserva->user->name }}
                            </td>

                            <td>
                                {{ $reserva->servicio->nombre }}
                            </td>

                            <td>
                                {{ $reserva->horario->fecha }}
                            </td>

                            <td>
                                {{ $reserva->horario->hora_inicio }}
                            </td>

                            <td>

                                @if($reserva->estado == 'Pendiente')

                                    <span class="badge bg-warning text-dark">
                                        Pendiente
                                    </span>

                                @elseif($reserva->estado == 'Confirmada')

                                    <span class="badge bg-primary">
                                        Confirmada
                                    </span>

                                @elseif($reserva->estado == 'Completada')

                                    <span class="badge bg-success">
                                        Completada
                                    </span>

                                @else

                                    <span class="badge bg-danger">
                                        Cancelada
                                    </span>

                                @endif

                            </td>

                        </tr>

                    @empty

                        <tr>

                            <td colspan="6" class="text-center">

                                No hay reservas registradas.

                            </td>

                        </tr>

                    @endforelse

                </tbody>

            </table>

        </div>

    </div>

</div>

</body>
</html>
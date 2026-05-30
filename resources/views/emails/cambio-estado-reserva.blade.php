<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
</head>

<body>

    <h2>Actualización de reserva</h2>

    <p>
        Hola {{ $reserva->user->name }},
    </p>

    <p>
        El estado de tu reserva ha cambiado.
    </p>

    <hr>

    <p>
        <strong>Servicio:</strong>
        {{ $reserva->servicio->nombre }}
    </p>

    <p>
        <strong>Fecha:</strong>
        {{ \Carbon\Carbon::parse($reserva->horario->fecha)->format('d/m/Y') }}
    </p>

    <p>
        <strong>Hora:</strong>
        {{ \Carbon\Carbon::parse($reserva->horario->hora_inicio)->format('H:i') }}
    </p>

    <p>
        <strong>Nuevo estado:</strong>
        {{ $reserva->estado }}
    </p>

</body>

</html>
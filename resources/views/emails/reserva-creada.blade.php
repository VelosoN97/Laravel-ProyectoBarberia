<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <title>Reserva creada</title>
</head>

<body>

    <h2>Reserva creada correctamente</h2>

    <p>
        Hola {{ $reserva->user->name }},
    </p>

    <p>
        Tu reserva ha sido registrada correctamente.
    </p>

    <hr>

    <p>
        <strong>Servicio:</strong>
        {{ $reserva->servicio->nombre }}
    </p>

    <p>
        <strong>Fecha:</strong>
        {{ $reserva->horario->fecha }}
    </p>

    <p>
        <strong>Hora:</strong>
        {{ $reserva->horario->hora_inicio }}
    </p>

    <p>
        <strong>Estado:</strong>
        {{ $reserva->estado }}
    </p>

    <hr>

    <p>
        Gracias por preferir nuestra barbería.
    </p>

</body>

</html>
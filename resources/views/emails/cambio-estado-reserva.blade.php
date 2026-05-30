<!DOCTYPE html>
<html lang="es">

<head>

    <meta charset="UTF-8">

    <title>Actualización de reserva</title>

</head>

<body style="
    margin:0;
    padding:0;
    background:#f5f5f5;
    font-family:Arial, Helvetica, sans-serif;
">

    <div style="
        max-width:600px;
        margin:40px auto;
        background:white;
        border-radius:10px;
        overflow:hidden;
        box-shadow:0 2px 10px rgba(0,0,0,.1);
    ">

        <div style="
            background:#212529;
            color:white;
            padding:25px;
            text-align:center;
        ">

            <h1 style="margin:0;">

                Barbería App

            </h1>

        </div>

        <div style="padding:30px;">

            <h2 style="margin-top:0;">

                Actualización de reserva 🔔

            </h2>

            <p>

                Hola <strong>{{ $reserva->user->name }}</strong>,

            </p>

            <p>

                El estado de tu reserva ha sido actualizado.

            </p>

            <div style="
                background:#f8f9fa;
                border:1px solid #dee2e6;
                border-radius:8px;
                padding:20px;
                margin:20px 0;
            ">

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
                    {{ \Carbon\Carbon::parse($reserva->horario->hora_inicio)->format('H:i') }} hrs
                </p>

                <p>

                    <strong>Nuevo estado:</strong>

                    @if($reserva->estado == 'Pendiente')

                        <span style="
                            background:#ffc107;
                            padding:4px 10px;
                            border-radius:5px;
                            font-weight:bold;
                        ">

                            Pendiente

                        </span>

                    @elseif($reserva->estado == 'Confirmada')

                        <span style="
                            background:#0d6efd;
                            color:white;
                            padding:4px 10px;
                            border-radius:5px;
                            font-weight:bold;
                        ">

                            Confirmada

                        </span>

                    @elseif($reserva->estado == 'Completada')

                        <span style="
                            background:#198754;
                            color:white;
                            padding:4px 10px;
                            border-radius:5px;
                            font-weight:bold;
                        ">

                            Completada

                        </span>

                    @else

                        <span style="
                            background:#dc3545;
                            color:white;
                            padding:4px 10px;
                            border-radius:5px;
                            font-weight:bold;
                        ">

                            Cancelada

                        </span>

                    @endif

                </p>

            </div>

            <p>

                Gracias por utilizar nuestros servicios.

            </p>

        </div>

        <div style="
            background:#f8f9fa;
            text-align:center;
            padding:15px;
            color:#6c757d;
            font-size:12px;
        ">

            Barbería App © {{ date('Y') }}

        </div>

    </div>

</body>

</html>
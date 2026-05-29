<!DOCTYPE html>
<html lang="es">

<head>

    <meta charset="UTF-8">

    <title>Reservas PDF</title>

    <style>

        body {

            font-family: Arial, sans-serif;

        }

        table {

            width: 100%;
            border-collapse: collapse;

            margin-top: 20px;

        }

        th, td {

            border: 1px solid #000;
            padding: 8px;
            text-align: left;

        }

        th {

            background: #eee;

        }

    </style>

</head>

<body>

    <h2>

        Reporte de Reservas

    </h2>

    <table>

        <thead>

            <tr>

                <th>Cliente</th>
                <th>Servicio</th>
                <th>Fecha</th>
                <th>Hora</th>
                <th>Estado</th>

            </tr>

        </thead>

        <tbody>

            @foreach($reservas as $reserva)

                <tr>

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

                        {{ $reserva->estado }}

                    </td>

                </tr>

            @endforeach

        </tbody>

    </table>

</body>

</html>
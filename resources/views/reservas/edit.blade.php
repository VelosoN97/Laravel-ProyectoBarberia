<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Editar reserva</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
</head>

<body class="bg-light">
    <div class="container py-5">
        <div class="card shadow-sm">
            <div class="card-body">
                <h1 class="h3 mb-4">Editar reserva</h1>
                <form action="{{ route('reservas.update', $reserva->id)}}" method="POST">
                    @csrf
                    @method('PUT')
                    <div class="mb-3">
                        <label class="form-label">Servicio</label>
                        <select name="servicio_id" class="form-select">
                            @foreach ($servicios as $servicio)
                                <option value="{{ $servicio->id }}" {{ $reserva->servicio_id == $servicio->id ? 'selected' : '' }}>
                                    {{ $servicio->nombre }}
                                </option>
                                @endforeach
                        </select>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Horario</label>
                        <select name="horario_id" class="form-select">
                            @foreach ($horarios as $horario)
                                <option value="{{ $horario->id }}" {{ $reserva->horario_id == $horario->id ? 'selected' : '' }}>
                                    {{ $horario->fecha }}

                                    -

                                    {{ $horario->hora_inicio }}
                                </option>
                                @endforeach
                        </select>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Estado</label>
                        <select name="estado" class="form-select">
                            <option value="Pendiente" {{ $reserva->estado == 'Pendiente' ? 'selected' : '' }}>
                                Pendiente
                            </option>
                            <option value="Confirmada" {{ $reserva->estado == 'Confirmada' ? 'selected' : '' }}>
                                Confirmada
                            </option>
                            <option value="Cancelada" {{ $reserva->estado == 'Cancelada' ? 'selected' : '' }}>
                                Cancelada
                            </option>
                            <option value="Completada" {{ $reserva->estado == 'Completada' ? 'selected' : '' }}>
                                Completada
                            </option>
                        </select>
                    </div>
                    <button class="btn btn-primary">Actualizar</button>
                    <a href="{{ route('reservas.index') }}" class="btn btn-secondary">Volver</a>
                </form>
            </div>
        </div>
    </div>
</body>

</html>
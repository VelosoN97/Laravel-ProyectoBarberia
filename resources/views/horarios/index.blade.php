<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Horarios</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
</head>

<body class="bg-light">
    <div class="container py-5">
        <div class="card shadow-sm">
            <div class="card-body">
                <div class="d-flex justify-content-between align-items-center mb-4">
                    <h1 class="h3 mb-0">Horarios disponibles</h1>
                    <a href="{{ route('horarios.create') }}" class="btn btn-primary">
                        Agregar horario
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
                            <th>Fecha</th>
                            <th>Hora inicio</th>
                            <th>Hora fin</th>
                            <th>Estado</th>
                            <th width="180">Acciones</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($horarios as $horario)
                        <tr>
                            <td>{{ $horario->id }}</td>
                            <td>{{ $horario->fecha }}</td>
                            <td>{{ $horario->hora_inicio }}</td>
                            <td>{{ $horario->hora_fin }}</td>
                            <td>
                                @if($horario->estado)
                                <span class="badge bg-success">Disponible</span>
                                @else
                                <span class="badge bg-secondary">No disponible</span>
                                @endif
                            </td>
                            <td>
                                <a href="{{ route('horarios.edit', $horario->id) }}" class="btn btn-warning btn-sm">
                                    Editar
                                </a>

                                <form action="{{ route('horarios.destroy', $horario->id) }}" method="POST" class="d-inline">
                                    @csrf
                                    @method('DELETE')

                                    <button type="submit" class="btn btn-danger btn-sm" onclick="return confirm('¿Seguro que deseas eliminar este horario?')">
                                        Eliminar
                                    </button>
                                </form>
                            </td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="6" class="text-center">No hay horarios registrados.</td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
                <a href="{{ route('servicios.index') }}" class="btn btn-secondary">
                    Volver a servicios
                </a>
            </div>
        </div>
    </div>
</body>

</html>
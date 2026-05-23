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
                    <h1 class="h3 mb-0">Reservas</h1>
                    <a href="{{ route('reservas.create') }}"
                        class="btn btn-primary">Crear reserva</a>
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
                            <th width="180">Acciones</th>
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
                                <select
                                    class="form-select estado-select"
                                    data-id="{{ $reserva->id }}">

                                    <option value="Pendiente"
                                        {{ $reserva->estado == 'Pendiente' ? 'selected' : '' }}>
                                        Pendiente
                                    </option>

                                    <option value="Confirmada"
                                        {{ $reserva->estado == 'Confirmada' ? 'selected' : '' }}>
                                        Confirmada
                                    </option>

                                    <option value="Completada"
                                        {{ $reserva->estado == 'Completada' ? 'selected' : '' }}>
                                        Completada
                                    </option>

                                    <option value="Cancelada"
                                        {{ $reserva->estado == 'Cancelada' ? 'selected' : '' }}>
                                        Cancelada
                                    </option>

                                </select>
                            </td>
                            <td>

                                <a href="{{ route('reservas.edit', $reserva->id) }}"
                                    class="btn btn-warning btn-sm">

                                    Editar

                                </a>

                                <form action="{{ route('reservas.destroy', $reserva->id) }}"
                                    method="POST"
                                    class="d-inline">

                                    @csrf
                                    @method('DELETE')

                                    <button type="submit"
                                        class="btn btn-danger btn-sm"
                                        onclick="return confirm('¿Eliminar reserva?')">

                                        Eliminar

                                    </button>

                                </form>

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
    <script>
        document.querySelectorAll('.estado-select')
            .forEach(select => {

                select.addEventListener('change', function() {

                    let reservaId = this.dataset.id;

                    let estado = this.value;

                    fetch(`/reservas/${reservaId}/estado`, {

                            method: 'PATCH',

                            headers: {
                                'Content-Type': 'application/json',

                                'X-CSRF-TOKEN': '{{ csrf_token() }}'
                            },

                            body: JSON.stringify({
                                estado: estado
                            })

                        })
                        .then(response => response.json())

                        .then(data => {

                            console.log(data);

                            alert(data.message);

                        })
                        .catch(error => {

                            console.error(error);

                            alert('Error al actualizar');

                        });

                });

            });
    </script>
</body>

</html>
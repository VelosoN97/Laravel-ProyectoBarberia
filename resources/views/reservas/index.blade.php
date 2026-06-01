@extends('layouts.main')

@section('title', 'Reservas')

@section('content')

    <div class="card shadow-sm">

        <div class="card-body">

            <div class="d-flex justify-content-between align-items-center mb-4">

                <h1 class="h3 mb-0">
                    @if (auth()->user()->role == 'admin')
                        Gestión de Reservas
                    @else
                        Mi Historial de Reservas
                    @endif
                </h1>
                <div class="d-flex gap-2">

                    <a href="{{ route('reservas.create') }}" class="btn btn-primary">

                        Crear reserva

                    </a>
                    @if (auth()->user()->role == 'admin')
                        <a href="{{ route('reservas.pdf') }}" class="btn btn-danger">

                            Exportar todas las reservas

                        </a>
                    @else
                        <a href="{{ route('reservas.pdf') }}" class="btn btn-danger">

                            Exportar mis reservas

                        </a>
                    @endif
                </div>
            </div>
            <form method="GET" action="{{ route('reservas.index') }}" class="row g-3 mb-4">

                <div class="col-md-4">

                    <input type="text" name="buscar" class="form-control" placeholder="Buscar cliente..."
                        value="{{ request('buscar') }}">

                </div>

                <div class="col-md-3">

                    <select name="estado" class="form-select">

                        <option value="">
                            Todos los estados
                        </option>

                        <option value="Pendiente" {{ request('estado') == 'Pendiente' ? 'selected' : '' }}>

                            Pendiente

                        </option>

                        <option value="Confirmada" {{ request('estado') == 'Confirmada' ? 'selected' : '' }}>

                            Confirmada

                        </option>

                        <option value="Completada" {{ request('estado') == 'Completada' ? 'selected' : '' }}>

                            Completada

                        </option>

                        <option value="Cancelada" {{ request('estado') == 'Cancelada' ? 'selected' : '' }}>

                            Cancelada

                        </option>

                    </select>

                </div>

                <div class="col-md-3">

                    <input type="date" name="fecha" class="form-control" value="{{ request('fecha') }}">

                </div>

                <div class="col-md-2 d-grid">

                    <button class="btn btn-primary">

                        Filtrar

                    </button>

                </div>

            </form>

            @if (session('success'))
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
                        @if (auth()->user()->role == 'admin')
                            <th width="180">Acciones</th>
                        @endif

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

                                @if (auth()->user()->role == 'admin')
                                    <select class="form-select estado-select" data-id="{{ $reserva->id }}">

                                        <option value="Pendiente" {{ $reserva->estado == 'Pendiente' ? 'selected' : '' }}>
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

                                        <option value="Cancelada" {{ $reserva->estado == 'Cancelada' ? 'selected' : '' }}>
                                            Cancelada
                                        </option>

                                    </select>
                                @else
                                    <div class="d-flex flex-column gap-2">

                                        <span
                                            class="badge

            @if ($reserva->estado == 'Pendiente') bg-warning
            @elseif($reserva->estado == 'Confirmada')
                bg-primary
            @elseif($reserva->estado == 'Completada')
                bg-success
            @else
                bg-danger @endif

        ">

                                            {{ $reserva->estado }}

                                        </span>

                                        @if ($reserva->estado == 'Pendiente')
                                            <button type="button" class="btn btn-success btn-sm btn-confirmar"
                                                data-id="{{ $reserva->id }}">

                                                Confirmar asistencia

                                            </button>

                                            <button type="button" class="btn btn-danger btn-sm btn-cancelar"
                                                data-id="{{ $reserva->id }}">

                                                Cancelar reserva

                                            </button>
                                        @elseif($reserva->estado == 'Confirmada')
                                            <button type="button" class="btn btn-danger btn-sm btn-cancelar"
                                                data-id="{{ $reserva->id }}">

                                                Cancelar reserva

                                            </button>
                                        @endif

                                    </div>
                                @endif

                            </td>

                            @if (auth()->user()->role == 'admin')
                                <td>

                                    <a href="{{ route('reservas.edit', $reserva->id) }}" class="btn btn-warning btn-sm">

                                        Editar

                                    </a>

                                    <form action="{{ route('reservas.destroy', $reserva->id) }}" method="POST"
                                        class="d-inline">

                                        @csrf
                                        @method('DELETE')

                                        <button type="button" class="btn btn-danger btn-sm btn-eliminar">

                                            Eliminar

                                        </button>

                                    </form>

                                </td>
                            @endif

                        </tr>

                    @empty

                        <tr>

                            <td colspan="7" class="text-center">

                                No hay reservas registradas.

                            </td>

                        </tr>
                    @endforelse

                </tbody>

            </table>
            <div class="mt-4">
                {{ $reservas->links() }}
            </div>

        </div>

    </div>

@endsection

@section('scripts')

    <script>
        function actualizarEstado(reservaId, estado) {

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

                    Swal.fire({

                        icon: 'success',
                        title: 'Éxito',
                        text: data.message

                    }).then(() => {

                        location.reload();

                    });

                });

        }
    </script>
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

                            Swal.fire({

                                icon: 'success',
                                title: 'Éxito',
                                text: data.message,
                                timer: 1500,
                                showConfirmButton: false

                            });

                        })

                        .catch(error => {

                            console.error(error);

                            Swal.fire({

                                icon: 'error',
                                title: 'Error',
                                text: 'No se pudo actualizar'

                            });

                        });

                });

            });
    </script>
    <script>
        document.querySelectorAll('.btn-confirmar')
            .forEach(button => {

                button.addEventListener('click', function() {

                    actualizarEstado(
                        this.dataset.id,
                        'Confirmada'
                    );

                });

            });

        document.querySelectorAll('.btn-cancelar')
            .forEach(button => {

                button.addEventListener('click', function() {

                    let reservaId = this.dataset.id;

                    Swal.fire({

                        title: '¿Cancelar reserva?',
                        text: 'Esta acción no se puede deshacer',
                        icon: 'warning',

                        showCancelButton: true,

                        confirmButtonText: 'Sí, cancelar',
                        cancelButtonText: 'Volver'

                    }).then((result) => {

                        if (result.isConfirmed) {

                            actualizarEstado(
                                reservaId,
                                'Cancelada'
                            );

                        }

                    });

                });

            });
    </script>

    <script>
        document.querySelectorAll('.btn-eliminar')
            .forEach(button => {

                button.addEventListener('click', function() {

                    let form = this.closest('form');

                    Swal.fire({

                        title: '¿Eliminar reserva?',
                        text: 'Esta acción no se puede deshacer',
                        icon: 'warning',

                        showCancelButton: true,

                        confirmButtonText: 'Sí, eliminar',
                        cancelButtonText: 'Cancelar'

                    }).then((result) => {

                        if (result.isConfirmed) {

                            form.submit();

                        }

                    });

                });

            });
    </script>

@endsection

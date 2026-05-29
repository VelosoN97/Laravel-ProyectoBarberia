@extends('layouts.main')

@section('title', 'Reservas')

@section('content')

    <div class="card shadow-sm">

        <div class="card-body">

            <div class="d-flex justify-content-between align-items-center mb-4">

                <h1 class="h3 mb-0">
                    Reservas
                </h1>

                <a href="{{ route('reservas.create') }}" class="btn btn-primary">

                    Crear reserva

                </a>
                <a href="{{ route('reservas.pdf') }}" class="btn btn-danger">

                    Exportar PDF

                </a>

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

                                <select class="form-select estado-select" data-id="{{ $reserva->id }}">

                                    <option value="Pendiente" {{ $reserva->estado == 'Pendiente' ? 'selected' : '' }}>
                                        Pendiente
                                    </option>

                                    <option value="Confirmada" {{ $reserva->estado == 'Confirmada' ? 'selected' : '' }}>
                                        Confirmada
                                    </option>

                                    <option value="Completada" {{ $reserva->estado == 'Completada' ? 'selected' : '' }}>
                                        Completada
                                    </option>

                                    <option value="Cancelada" {{ $reserva->estado == 'Cancelada' ? 'selected' : '' }}>
                                        Cancelada
                                    </option>

                                </select>

                            </td>

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

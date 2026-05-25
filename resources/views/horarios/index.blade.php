@extends('layouts.main')

@section('title', 'Horarios')

@section('content')

<div class="card shadow-sm">

    <div class="card-body">

        <div class="d-flex justify-content-between align-items-center mb-4">

            <h1 class="h3 mb-0">

                Horarios

            </h1>

            <a href="{{ route('horarios.create') }}"
               class="btn btn-primary">

                Crear horario

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
                    <th>Hora Inicio</th>
                    <th>Hora Fin</th>
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

                                <span class="badge bg-success">

                                    Disponible

                                </span>

                            @else

                                <span class="badge bg-danger">

                                    Ocupado

                                </span>

                            @endif

                        </td>

                        <td>

                            <a href="{{ route('horarios.edit', $horario->id) }}"
                               class="btn btn-warning btn-sm">

                                Editar

                            </a>

                            <form action="{{ route('horarios.destroy', $horario->id) }}"
                                  method="POST"
                                  class="d-inline">

                                @csrf
                                @method('DELETE')

                                <button type="button"
                                        class="btn btn-danger btn-sm btn-eliminar">

                                    Eliminar

                                </button>

                            </form>

                        </td>

                    </tr>

                @empty

                    <tr>

                        <td colspan="6" class="text-center">

                            No hay horarios registrados.

                        </td>

                    </tr>

                @endforelse

            </tbody>

        </table>

    </div>

</div>

@endsection

@section('scripts')

<script>

document.querySelectorAll('.btn-eliminar')
.forEach(button => {

    button.addEventListener('click', function() {

        let form = this.closest('form');

        Swal.fire({

            title: '¿Eliminar horario?',
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
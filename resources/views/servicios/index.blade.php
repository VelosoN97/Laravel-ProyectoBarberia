@extends('layouts.main')

@section('title', 'Servicios')

@section('content')

<div class="card shadow-sm">

    <div class="card-body">

        <div class="d-flex justify-content-between align-items-center mb-4">

            <h1 class="h3 mb-0">

                Servicios

            </h1>

            <a href="{{ route('servicios.create') }}"
                class="btn btn-primary">

                Crear servicio

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
                    <th>Nombre</th>
                    <th>Precio</th>
                    <th>Duración</th>
                    <th>Estado</th>
                    <th width="180">Acciones</th>

                </tr>

            </thead>

            <tbody>

                @forelse($servicios as $servicio)

                <tr>

                    <td>{{ $servicio->id }}</td>

                    <td>{{ $servicio->nombre }}</td>

                    <td>

                        ${{ number_format($servicio->precio, 0, ',', '.') }}

                    </td>

                    <td>

                        {{ $servicio->duracion }} min

                    </td>

                    <td>

                        @if($servicio->estado)

                        <span class="badge bg-success">

                            Activo

                        </span>

                        @else

                        <span class="badge bg-danger">

                            Inactivo

                        </span>

                        @endif

                    </td>

                    <td>

                        <a href="{{ route('servicios.edit', $servicio->id) }}"
                            class="btn btn-warning btn-sm">

                            Editar

                        </a>

                        <form action="{{ route('servicios.destroy', $servicio->id) }}"
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

                        No hay servicios registrados.

                    </td>

                </tr>

                @endforelse

            </tbody>

        </table>
        <div class="mt-4">

            {{ $servicios->links() }}

        </div>

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

                    title: '¿Eliminar servicio?',
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
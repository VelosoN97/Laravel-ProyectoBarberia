@extends('layouts.main')

@section('title', 'Editar Reserva')

@section('content')

<div class="card shadow-sm">

    <div class="card-body">

        <h1 class="h3 mb-4">

            Editar reserva

        </h1>

        <form action="{{ route('reservas.update', $reserva->id) }}"
              method="POST">

            @csrf
            @method('PUT')

            <div class="mb-3">

                <label class="form-label">

                    Servicio

                </label>

                <select name="servicio_id"
                        class="form-select">

                    @foreach($servicios as $servicio)

                        <option value="{{ $servicio->id }}"
                            {{ $reserva->servicio_id == $servicio->id ? 'selected' : '' }}>

                            {{ $servicio->nombre }}

                        </option>

                    @endforeach

                </select>

            </div>

            <div class="mb-3">

                <label class="form-label">

                    Horario

                </label>

                <select name="horario_id"
                        class="form-select">

                    @foreach($horarios as $horario)

                        <option value="{{ $horario->id }}"
                            {{ $reserva->horario_id == $horario->id ? 'selected' : '' }}>

                            {{ $horario->fecha }}

                            -

                            {{ $horario->hora_inicio }}

                        </option>

                    @endforeach

                </select>

            </div>

            <div class="mb-3">

                <label class="form-label">

                    Estado

                </label>

                <select name="estado"
                        class="form-select">

                    <option value="Pendiente"
                        {{ $reserva->estado == 'Pendiente' ? 'selected' : '' }}>

                        Pendiente

                    </option>

                    <option value="Confirmada"
                        {{ $reserva->estado == 'Confirmada' ? 'selected' : '' }}>

                        Confirmada

                    </option>

                    <option value="Cancelada"
                        {{ $reserva->estado == 'Cancelada' ? 'selected' : '' }}>

                        Cancelada

                    </option>

                    <option value="Completada"
                        {{ $reserva->estado == 'Completada' ? 'selected' : '' }}>

                        Completada

                    </option>

                </select>

            </div>

            <button class="btn btn-primary">

                Actualizar

            </button>

            <a href="{{ route('reservas.index') }}"
               class="btn btn-secondary">

                Volver

            </a>

        </form>

    </div>

</div>

@endsection
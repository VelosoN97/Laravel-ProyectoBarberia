@extends('layouts.main')

@section('title', 'Editar Horario')

@section('content')

<div class="card shadow-sm">

    <div class="card-body">

        <h1 class="h3 mb-4">

            Editar horario

        </h1>

        <form action="{{ route('horarios.update', $horario->id) }}"
              method="POST">

            @csrf
            @method('PUT')

            <div class="mb-3">

                <label class="form-label">

                    Fecha

                </label>

                <input type="date"
                       name="fecha"
                       class="form-control"
                       value="{{ $horario->fecha }}">

            </div>

            <div class="mb-3">

                <label class="form-label">

                    Hora inicio

                </label>

                <input type="time"
                       name="hora_inicio"
                       class="form-control"
                       value="{{ $horario->hora_inicio }}">

            </div>

            <div class="mb-3">

                <label class="form-label">

                    Hora fin

                </label>

                <input type="time"
                       name="hora_fin"
                       class="form-control"
                       value="{{ $horario->hora_fin }}">

            </div>

            <div class="mb-3">

                <label class="form-label">

                    Estado

                </label>

                <select name="estado"
                        class="form-select">

                    <option value="1"
                        {{ $horario->estado ? 'selected' : '' }}>

                        Disponible

                    </option>

                    <option value="0"
                        {{ !$horario->estado ? 'selected' : '' }}>

                        Ocupado

                    </option>

                </select>

            </div>

            <button class="btn btn-primary">

                Actualizar

            </button>

            <a href="{{ route('horarios.index') }}"
               class="btn btn-secondary">

                Volver

            </a>

        </form>

    </div>

</div>

@endsection
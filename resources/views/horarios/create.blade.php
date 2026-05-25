@extends('layouts.main')

@section('title', 'Crear Horario')

@section('content')

<div class="card shadow-sm">

    <div class="card-body">

        <h1 class="h3 mb-4">

            Crear horario

        </h1>

        <form action="{{ route('horarios.store') }}"
              method="POST">

            @csrf

            <div class="mb-3">

                <label class="form-label">

                    Fecha

                </label>

                <input type="date"
                       name="fecha"
                       class="form-control">

            </div>

            <div class="mb-3">

                <label class="form-label">

                    Hora inicio

                </label>

                <input type="time"
                       name="hora_inicio"
                       class="form-control">

            </div>

            <div class="mb-3">

                <label class="form-label">

                    Hora fin

                </label>

                <input type="time"
                       name="hora_fin"
                       class="form-control">

            </div>

            <div class="mb-3">

                <label class="form-label">

                    Estado

                </label>

                <select name="estado"
                        class="form-select">

                    <option value="1">

                        Disponible

                    </option>

                    <option value="0">

                        Ocupado

                    </option>

                </select>

            </div>

            <button class="btn btn-primary">

                Guardar

            </button>

            <a href="{{ route('horarios.index') }}"
               class="btn btn-secondary">

                Volver

            </a>

        </form>

    </div>

</div>

@endsection
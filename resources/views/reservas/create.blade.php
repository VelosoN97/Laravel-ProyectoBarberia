@extends('layouts.main')

@section('title', 'Crear Reserva')

@section('content')

<div class="card shadow-sm">

    <div class="card-body">

        <h1 class="h3 mb-4">

            Crear reserva

        </h1>

        <form action="{{ route('reservas.store') }}"
              method="POST">

            @csrf

            <div class="mb-3">

                <label class="form-label">

                    Servicio

                </label>

                <select name="servicio_id"
                        class="form-select">

                    <option value="">
                        Seleccione un servicio
                    </option>

                    @foreach($servicios as $servicio)

                        <option value="{{ $servicio->id }}">

                            {{ $servicio->nombre }}

                            -

                            ${{ number_format($servicio->precio, 0, ',', '.') }}

                        </option>

                    @endforeach

                </select>

                @error('servicio_id')

                    <small class="text-danger">

                        {{ $message }}

                    </small>

                @enderror

            </div>

            <div class="mb-3">

                <label class="form-label">

                    Horario

                </label>

                <select name="horario_id"
                        class="form-select">

                    <option value="">
                        Seleccione un horario
                    </option>

                    @foreach($horarios as $horario)

                        <option value="{{ $horario->id }}">

                            {{ $horario->fecha }}

                            -

                            {{ $horario->hora_inicio }}

                        </option>

                    @endforeach

                </select>

                @error('horario_id')

                    <small class="text-danger">

                        {{ $message }}

                    </small>

                @enderror

            </div>

            <button class="btn btn-primary">

                Guardar reserva

            </button>

            <a href="{{ route('reservas.index') }}"
               class="btn btn-secondary">

                Volver

            </a>

        </form>

    </div>

</div>

@endsection
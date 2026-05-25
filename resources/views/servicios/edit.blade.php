@extends('layouts.main')

@section('title', 'Editar Servicio')

@section('content')

<div class="card shadow-sm">

    <div class="card-body">

        <h1 class="h3 mb-4">

            Editar servicio

        </h1>

        <form action="{{ route('servicios.update', $servicio->id) }}"
              method="POST">

            @csrf
            @method('PUT')

            <div class="mb-3">

                <label class="form-label">

                    Nombre

                </label>

                <input type="text"
                       name="nombre"
                       class="form-control"
                       value="{{ $servicio->nombre }}">

            </div>

            <div class="mb-3">

                <label class="form-label">

                    Precio

                </label>

                <input type="number"
                       name="precio"
                       class="form-control"
                       value="{{ $servicio->precio }}">

            </div>

            <div class="mb-3">

                <label class="form-label">

                    Duración

                </label>

                <input type="number"
                       name="duracion"
                       class="form-control"
                       value="{{ $servicio->duracion }}">

            </div>

            <div class="mb-3">

                <label class="form-label">

                    Estado

                </label>

                <select name="estado"
                        class="form-select">

                    <option value="1"
                        {{ $servicio->estado ? 'selected' : '' }}>

                        Activo

                    </option>

                    <option value="0"
                        {{ !$servicio->estado ? 'selected' : '' }}>

                        Inactivo

                    </option>

                </select>

            </div>

            <button class="btn btn-primary">

                Actualizar

            </button>

            <a href="{{ route('servicios.index') }}"
               class="btn btn-secondary">

                Volver

            </a>

        </form>

    </div>

</div>

@endsection
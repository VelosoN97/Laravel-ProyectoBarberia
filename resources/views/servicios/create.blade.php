@extends('layouts.main')

@section('title', 'Crear Servicio')

@section('content')

<div class="card shadow-sm">

    <div class="card-body">

        <h1 class="h3 mb-4">

            Crear servicio

        </h1>

        <form action="{{ route('servicios.store') }}"
              method="POST">

            @csrf

            <div class="mb-3">

                <label class="form-label">

                    Nombre

                </label>

                <input type="text"
                       name="nombre"
                       class="form-control">

                @error('nombre')

                    <small class="text-danger">

                        {{ $message }}

                    </small>

                @enderror

            </div>

            <div class="mb-3">

                <label class="form-label">

                    Precio

                </label>

                <input type="number"
                       name="precio"
                       class="form-control">

                @error('precio')

                    <small class="text-danger">

                        {{ $message }}

                    </small>

                @enderror

            </div>

            <div class="mb-3">

                <label class="form-label">

                    Duración (minutos)

                </label>

                <input type="number"
                       name="duracion"
                       class="form-control">

                @error('duracion')

                    <small class="text-danger">

                        {{ $message }}

                    </small>

                @enderror

            </div>

            <div class="mb-3">

                <label class="form-label">

                    Estado

                </label>

                <select name="estado"
                        class="form-select">

                    <option value="1">

                        Activo

                    </option>

                    <option value="0">

                        Inactivo

                    </option>

                </select>

            </div>

            <button class="btn btn-primary">

                Guardar

            </button>

            <a href="{{ route('servicios.index') }}"
               class="btn btn-secondary">

                Volver

            </a>

        </form>

    </div>

</div>

@endsection
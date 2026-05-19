<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Editar Servicio</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
</head>

<body class="bg-light">
    <div class="container py-5">
        <div class="card shadow-sm">
            <div class="card-body">
                <h1 class="h3 mb-4">Editar servicio</h1>
                <form action="{{ route('servicios.update', $servicio->id) }}" method="POST">
                    @csrf
                    @method('PUT')

                    <div class="mb-3">
                        <label class="form-label">Nombre del servicio</label>
                        <input type="text" name="nombre" class="form-control" value="{{ old('nombre', $servicio->nombre) }}">
                        @error('nombre')
                        <small class="text-danger">{{ $message }}</small>
                        @enderror
                    </div>

                    <div class="mb-3">
                        <label class="form-label">Descripción</label>
                        <textarea name="descripcion" class="form-control">{{ old('descripcion', $servicio->descripcion) }}</textarea>
                        @error('descripcion')
                        <small class="text-danger">{{ $message }}</small>
                        @enderror
                    </div>

                    <div class="mb-3">
                        <label class="form-label">Precio</label>
                        <input type="number" name="precio" class="form-control" value="{{ old('precio', $servicio->precio) }}">
                        @error('precio')
                        <small class="text-danger">{{ $message }}</small>
                        @enderror
                    </div>

                    <div class="mb-3">
                        <label class="form-label">Duración en minutos</label>
                        <input type="number" name="duracion" class="form-control" value="{{ old('duracion', $servicio->duracion) }}">
                        @error('duracion')
                        <small class="text-danger">{{ $message }}</small>
                        @enderror
                    </div>

                    <div class="mb-3">
                        <label class="form-label">Estado</label>
                        <select name="estado" class="form-select">
                            <option value="1" {{ old('estado', $servicio->estado) == 1 ? 'selected' : '' }}>Activo</option>
                            <option value="0" {{ old('estado', $servicio->estado) == 0 ? 'selected' : '' }}>Inactivo</option>
                        </select>
                        @error('estado')
                        <small class="text-danger">{{ $message }}</small>
                        @enderror
                    </div>

                    <button type="submit" class="btn btn-primary">
                        Actualizar
                    </button>

                    <a href="{{ route('servicios.index') }}" class="btn btn-secondary">
                        Volver
                    </a>
                </form>
            </div>
        </div>
    </div>
</body>

</html>
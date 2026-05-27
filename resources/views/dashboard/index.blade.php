@extends('layouts.main')

@section('title', 'Dashboard')

@section('content')

    <h1 class="mb-4">

        Dashboard Administrador

    </h1>

    <div class="row g-4">

        <div class="col-md-3">

            <div class="card shadow-sm">

                <div class="card-body">

                    <h5>Total reservas</h5>

                    <h2>{{ $totalReservas }}</h2>

                </div>

            </div>

        </div>

        <div class="col-md-3">

            <div class="card shadow-sm">

                <div class="card-body">

                    <h5>Reservas pendientes</h5>

                    <h2>{{ $reservasPendientes }}</h2>

                </div>

            </div>

        </div>

        <div class="col-md-3">

            <div class="card shadow-sm">

                <div class="card-body">

                    <h5>Reservas completadas</h5>

                    <h2>{{ $reservasCompletadas }}</h2>

                </div>

            </div>

        </div>

        <div class="col-md-3">

            <div class="card shadow-sm">

                <div class="card-body">

                    <h5>Total clientes</h5>

                    <h2>{{ $totalClientes }}</h2>

                </div>

            </div>

        </div>

        <div class="col-md-12">

            <div class="card shadow-sm">

                <div class="card-body">

                    <h4>

                        Ingresos estimados:

                        ${{ number_format($ingresos, 0, ',', '.') }}

                    </h4>

                </div>

            </div>

        </div>

    </div>

    <div class="card shadow-sm mt-4">

        <div class="card-body">

            <h4 class="mb-4">

                Reservas por estado

            </h4>
            <div style="width: 400px; height: 400px; margin: auto;">
                <canvas id="graficoEstados"></canvas>
            </div>

        </div>

    </div>
    <div class="card shadow-sm mt-4">

        <div class="card-body">

            <h4 class="mb-4">

                Últimas reservas

            </h4>

            <table class="table table-bordered table-hover">

                <thead class="table-dark">

                    <tr>

                        <th>Cliente</th>
                        <th>Servicio</th>
                        <th>Fecha</th>
                        <th>Estado</th>

                    </tr>

                </thead>

                <tbody>

                    @foreach ($ultimasReservas as $reserva)
                        <tr>

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

                                @if ($reserva->estado == 'Pendiente')
                                    <span class="badge bg-warning text-dark">

                                        Pendiente

                                    </span>
                                @elseif($reserva->estado == 'Confirmada')
                                    <span class="badge bg-primary">

                                        Confirmada

                                    </span>
                                @elseif($reserva->estado == 'Completada')
                                    <span class="badge bg-success">

                                        Completada

                                    </span>
                                @else
                                    <span class="badge bg-danger">

                                        Cancelada

                                    </span>
                                @endif

                            </td>

                        </tr>
                    @endforeach

                </tbody>

            </table>

        </div>

    </div>
    <div class="card shadow-sm mt-4">

        <div class="card-body">

            <h4 class="mb-4">

                Servicios más solicitados

            </h4>

            <div style="max-width: 700px; margin:auto;">

                <canvas id="graficoServicios"></canvas>

            </div>

        </div>

    </div>

@endsection

@section('scripts')

    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>

    <script>
        const ctx = document.getElementById('graficoEstados');

        new Chart(ctx, {

            type: 'pie',

            data: {

                labels: [
                    'Pendientes',
                    'Confirmadas',
                    'Completadas',
                    'Canceladas'
                ],

                datasets: [{

                    data: [
                        {{ $pendientes }},
                        {{ $confirmadas }},
                        {{ $completadas }},
                        {{ $canceladas }}
                    ]

                }]

            }

        });
    </script>
    <script>
        const serviciosLabels = {!! json_encode($serviciosPopulares->pluck('nombre')) !!};

        const serviciosData = {!! json_encode($serviciosPopulares->pluck('reservas_count')) !!};

        const ctxServicios = document.getElementById('graficoServicios');

        new Chart(ctxServicios, {

            type: 'bar',

            data: {

                labels: serviciosLabels,

                datasets: [{

                    label: 'Cantidad reservas',

                    data: serviciosData

                }]

            },

            options: {

                responsive: true,

                plugins: {

                    legend: {

                        display: false

                    }

                }

            }

        });
    </script>
@endsection

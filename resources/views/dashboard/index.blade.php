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

@endsection
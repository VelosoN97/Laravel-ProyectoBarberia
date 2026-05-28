@extends('layouts.main')

@section('title', 'Calendario')

@section('content')

<div class="card shadow-sm">

    <div class="card-body">

        <h2 class="mb-4">

            Calendario de reservas

        </h2>

        <div id="calendar"></div>

    </div>

</div>

@endsection

@section('scripts')

<link href='https://cdn.jsdelivr.net/npm/fullcalendar@6.1.15/index.global.min.css'
      rel='stylesheet'>

<script src='https://cdn.jsdelivr.net/npm/fullcalendar@6.1.15/index.global.min.js'></script>

<script>

document.addEventListener('DOMContentLoaded', function () {

    const calendarEl = document.getElementById('calendar');

    const calendar = new FullCalendar.Calendar(calendarEl, {

        initialView: 'dayGridMonth',

        locale: 'es',

        events: {!! json_encode($eventos) !!}

    });

    calendar.render();

});

</script>

@endsection
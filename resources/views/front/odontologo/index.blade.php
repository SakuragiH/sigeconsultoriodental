@extends('layouts.odontologo')

@section('content')
<div class="container mt-4">
    <h2>Citas Agendadas</h2>

    <div class="row g-3 mb-4">
        @foreach($citas as $cita)
            @php
                $fecha = \Carbon\Carbon::parse($cita->horario->fecha ?? now());
                $dia = $fecha->translatedFormat('l'); 
                $fecha_formateada = $fecha->format('d/m/Y');
            @endphp

            <div class="col-md-4 col-sm-6">
                <div class="card shadow-sm cita-card 
                    @if($cita->estado == 'Pendiente') cita-pendiente
                    @elseif($cita->estado == 'Confirmada') cita-confirmada
                    @elseif($cita->estado == 'Realizada') cita-realizada
                    @else cita-cancelada
                    @endif">
                    <div class="card-body p-2">
                        <h6 class="card-title mb-1">{{ $cita->servicio->nombre ?? 'Servicio' }}</h6>
                        <p class="mb-0"><strong>Paciente:</strong> {{ $cita->paciente->nombres ?? '' }} {{ $cita->paciente->apellidos ?? '' }}</p>
                        <p class="mb-0"><strong>Horario:</strong> {{ $cita->horario->hora_inicio ?? '' }} - {{ $cita->horario->hora_fin ?? '' }}</p>
                        <p class="mb-0"><strong>Día:</strong> {{ ucfirst($dia) }} | <strong>Fecha:</strong> {{ $fecha_formateada }}</p>
                        <p class="mb-0"><strong>Motivo:</strong> {{ $cita->motivo ?? 'Sin motivo' }}</p>
                        <p class="mb-0"><strong>Observaciones:</strong> {{ $cita->observaciones ?? 'N/A' }}</p>
                        <p class="mb-0"><strong>Estado:</strong> {{ $cita->estado }}</p>
                    </div>
                </div>
            </div>
        @endforeach
    </div>

    <!-- Calendario -->
    <div id="calendar"></div>
</div>

<!-- FullCalendar CSS & JS -->
<link href="https://cdn.jsdelivr.net/npm/@fullcalendar/core@6.1.8/index.global.min.css" rel="stylesheet">
<link href="https://cdn.jsdelivr.net/npm/@fullcalendar/daygrid@6.1.8/index.global.min.css" rel="stylesheet">
<link href="https://cdn.jsdelivr.net/npm/@fullcalendar/timegrid@6.1.8/index.global.min.css" rel="stylesheet">

<script src="https://cdn.jsdelivr.net/npm/@fullcalendar/core@6.1.8/index.global.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/@fullcalendar/daygrid@6.1.8/index.global.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/@fullcalendar/timegrid@6.1.8/index.global.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/@fullcalendar/interaction@6.1.8/index.global.min.js"></script>

<script>
document.addEventListener('DOMContentLoaded', function() {
    var calendarEl = document.getElementById('calendar');

    var calendar = new FullCalendar.Calendar(calendarEl, {
        initialView: 'dayGridMonth',
        locale: 'es',
        headerToolbar: {
            left: 'prev,next today',
            center: 'title',
            right: 'timeGridWeek,timeGridDay'
        },
        events: @json($events), // $events debe venir del controlador
        eventClick: function(info) {
            Swal.fire({
                icon: 'info',
                title: 'Cita con ' + info.event.extendedProps.paciente,
                html: '<strong>Motivo:</strong> ' + info.event.extendedProps.motivo +
                      '<br><strong>Observaciones:</strong> ' + info.event.extendedProps.observaciones
            });
        }
    });

    calendar.render();
});
</script>

<style>
.cita-card {
    border-radius: 12px;
    color: #fff;
    transition: transform 0.3s, box-shadow 0.3s;
    font-size: 0.9rem;
}
.cita-card:hover {
    transform: translateY(-4px);
    box-shadow: 0 6px 15px rgba(0,0,0,0.25);
}
.cita-card .card-body p,
.cita-card .card-body h6 {
    margin-bottom: 4px;
}
.cita-pendiente { background-color:#36808B; }
.cita-confirmada { background-color:#12403B; }
.cita-realizada { background-color:#5DA6A6; }
.cita-cancelada { background-color:#1A1D22; }
</style>
@endsection

@extends('layouts.usuario')

@section('content')
<div class="container mt-5">
    <h2>Mis Citas</h2>

    <!-- Mostrar alerta si el usuario aún no es paciente -->
    @if($noPaciente)
    <script>
    Swal.fire({
        icon: 'info',
        title: 'Aún no tienes citas',
        text: 'Debes agendar tu primera cita para registrarte como paciente.',
        confirmButtonColor: '#12403B'
    });
    </script>
    @endif

    <!-- SweetAlert -->
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    @if(session('success'))
    <script>
        Swal.fire({
            icon: 'success',
            title: '¡Cita Agendada!',
            text: '{{ session('success') }}',
            confirmButtonColor: '#12403B'
        });
    </script>
    @endif

    <!-- Mostrar citas en tarjetas -->
   @if($user->paciente && $user->paciente->citas->count() > 0)
    <div class="row g-3 mb-4">
        @foreach($user->paciente->citas as $cita)
           @php
                $fecha = \Carbon\Carbon::parse($cita->horario->fecha ?? now());
                $dia = $fecha->translatedFormat('l'); // día completo en español
                $fecha_formateada = $fecha->format('d/m/Y');
            @endphp

            <div class="col-md-4 col-sm-6">
                <div class="card shadow-sm cita-card 
                    @if($cita->estado == 'Pendiente') cita-pendiente
                    @elseif($cita->estado == 'Confirmada') cita-confirmada
                    @else cita-cancelada
                    @endif">
                    <div class="card-body p-2">
                        <h6 class="card-title mb-1">{{ $cita->servicio->nombre ?? 'Servicio' }}</h6>
                        <p class="mb-0"><strong>Odontólogo:</strong> {{ $cita->odontologo->nombres ?? 'N/A' }} {{ $cita->odontologo->apellidos ?? '' }}</p>
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
@endif

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
        initialView: 'timeGridWeek',
        locale: 'es',
        headerToolbar: {
            left: 'prev,next today',
            center: 'title',
            right: 'dayGridMonth,timeGridWeek,timeGridDay'
        },
        events: @json($events),
        eventClick: function(info) {
            Swal.fire({
                icon: 'info',
                title: 'Cita con ' + info.event.extendedProps.odontologo,
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
    background: linear-gradient(135deg, #36808B, #5DA6A6);
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
.cita-pendiente { background: linear-gradient(135deg, #36808B, #5DA6A6); }
.cita-confirmada { background: linear-gradient(135deg, #12403B, #36808B); }
.cita-cancelada { background: linear-gradient(135deg, #1A1D22, #5DA6A6); }
</style>
@endsection

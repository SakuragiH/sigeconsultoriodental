@extends('layouts.usuario')

@section('content')
<div class="container mt-5">
    <h2>Detalle de Cita</h2>

    @if(session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
    @endif

    <div class="card shadow-sm mt-3">
        <div class="card-body">
            <h4 class="card-title">{{ $cita->servicio->nombre ?? 'Servicio' }}</h4>
            <p><strong>Paciente:</strong> {{ $cita->paciente->nombres }} {{ $cita->paciente->apellidos }}</p>
            <p><strong>Odontólogo:</strong> {{ $cita->odontologo->nombres ?? $cita->odontologo->usuario->name ?? 'N/A' }} {{ $cita->odontologo->apellidos ?? '' }}</p>
            <p><strong>Horario:</strong> {{ $cita->horario->hora_inicio ?? '' }} - {{ $cita->horario->hora_fin ?? '' }}</p>
            <p><strong>Motivo:</strong> {{ $cita->motivo ?? 'Sin motivo' }}</p>
            <p><strong>Observaciones:</strong> {{ $cita->observaciones ?? 'N/A' }}</p>
            <p><strong>Estado:</strong> {{ $cita->estado }}</p>
        </div>
        <div class="card-footer">
            <a href="{{ route('usuario.citas') }}" class="btn btn-secondary">Volver a Mis Citas</a>
        </div>
    </div>

    <hr>

    <h4 class="mt-4">Calendario de Citas</h4>
    <div id="calendar"></div>
</div>
@endsection

@section('scripts')
<!-- Aquí luego se integrará FullCalendar -->
<script>
document.addEventListener('DOMContentLoaded', function() {
    var calendarEl = document.getElementById('calendar');

    var calendar = new FullCalendar.Calendar(calendarEl, {
        initialView: 'dayGridMonth',
        locale: 'es',
        headerToolbar: {
            left: 'prev,next today',
            center: 'title',
            right: 'dayGridMonth,timeGridWeek,timeGridDay'
        },
        events: [
            // Aquí luego puedes cargar las citas del usuario o de todos
            {
                title: '{{ $cita->servicio->nombre ?? "Cita" }}',
                start: '{{ $cita->horario->fecha ?? "" }}T{{ $cita->horario->hora_inicio ?? "" }}',
                end: '{{ $cita->horario->fecha ?? "" }}T{{ $cita->horario->hora_fin ?? "" }}',
                color: '#28a745'
            }
        ]
    });

    calendar.render();
});
</script>
@endsection

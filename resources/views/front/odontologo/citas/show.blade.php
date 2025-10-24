@extends('layouts.odontologo')

@section('title', 'Detalle de Cita')

@section('content')
<div class="container">
    <h2 class="mb-4">Detalle de Cita</h2>

    <div class="row g-4">

        <!-- Paciente -->
        <div class="col-md-4">
            <div class="card shadow-sm" style="border-top: 4px solid #36808B;">
                <div class="card-header bg-white">
                    <h5 class="card-title mb-0" style="color:#36808B;">Paciente</h5>
                </div>
                <div class="card-body">
                    <p><strong>Nombre:</strong> {{ $cita->paciente->nombres }} {{ $cita->paciente->apellidos }}</p>
                    <p><strong>Teléfono:</strong> {{ $cita->paciente->telefono ?? 'N/A' }}</p>
                    <p><strong>Email:</strong> {{ $cita->paciente->email ?? 'N/A' }}</p>
                </div>
            </div>
        </div>

        <!-- Servicio -->
        <div class="col-md-4">
            <div class="card shadow-sm" style="border-top: 4px solid #5DA6A6;">
                <div class="card-header bg-white">
                    <h5 class="card-title mb-0" style="color:#5DA6A6;">Servicio</h5>
                </div>
                <div class="card-body">
                    <p><strong>Nombre del servicio:</strong> {{ $cita->servicio->nombre }}</p>
                    <p><strong>Descripción:</strong> {{ $cita->servicio->descripcion ?? 'N/A' }}</p>
                </div>
            </div>
        </div>

        <!-- Horario -->
        <div class="col-md-4">
            <div class="card shadow-sm" style="border-top: 4px solid #12403B;">
                <div class="card-header bg-white">
                    <h5 class="card-title mb-0" style="color:#12403B;">Horario</h5>
                </div>
                <div class="card-body">
                    <p><strong>Fecha:</strong> {{ $cita->horario->fecha }}</p>
                    <p><strong>Hora:</strong> {{ $cita->horario->hora_inicio }} - {{ $cita->horario->hora_fin }}</p>
                    <p><strong>Estado:</strong> {{ $cita->estado }}</p>
                </div>
            </div>
        </div>

        <!-- Motivo y Observaciones -->
        <div class="col-md-12">
            <div class="card shadow-sm" style="border-top: 4px solid #1A1D22;">
                <div class="card-header bg-white">
                    <h5 class="card-title mb-0" style="color:#1A1D22;">Motivo y Observaciones</h5>
                </div>
                <div class="card-body">
                    <p><strong>Motivo:</strong> {{ $cita->motivo ?? 'N/A' }}</p>
                    <p><strong>Observaciones:</strong> {{ $cita->observaciones ?? 'N/A' }}</p>
                </div>
            </div>
        </div>

        <div class="col-md-12 mt-3">
            <a href="{{ route('odontologo.citas.index') }}" class="btn btn-secondary">
                <i class="fas fa-arrow-left"></i> Volver al listado
            </a>
        </div>
    </div>
</div>
@endsection

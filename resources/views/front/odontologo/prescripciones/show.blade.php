@extends('layouts.odontologo')

@section('title', 'Detalle de la Prescripción')

@section('content')
<div class="container">
    <h2 class="mb-4">Detalle de la Prescripción</h2>

    <div class="row g-4">

        <!-- Paciente y Cita -->
        <div class="col-md-6">
            <div class="card shadow-sm card-hover" style="border-top: 4px solid #36808B;">
                <div class="card-header bg-white">
                    <h5 class="card-title mb-0" style="color:#36808B;">Paciente / Cita</h5>
                </div>
                <div class="card-body">
                    @if($prescripcion->historial && $prescripcion->historial->cita)
                        <p><strong>Paciente:</strong> {{ $prescripcion->historial->cita->paciente->nombreCompleto() }}</p>
                        <p><strong>Servicio:</strong> {{ $prescripcion->historial->cita->servicio->nombre ?? 'N/A' }}</p>
                        <p><strong>Fecha:</strong> {{ \Carbon\Carbon::parse($prescripcion->historial->cita->horario->fecha)->format('d/m/Y') }}</p>
                        <p><strong>Hora:</strong> {{ \Carbon\Carbon::parse($prescripcion->historial->cita->horario->hora_inicio)->format('H:i') }}</p>
                        <p><strong>Motivo:</strong> {{ $prescripcion->historial->cita->motivo ?? 'Sin motivo' }}</p>
                    @else
                        <p><em>No hay historial o cita asociada</em></p>
                    @endif
                </div>
            </div>
        </div>

        <!-- Medicamento -->
        <div class="col-md-6">
            <div class="card shadow-sm card-hover" style="border-top: 4px solid #5DA6A6;">
                <div class="card-header bg-white">
                    <h5 class="card-title mb-0" style="color:#5DA6A6;">Medicamento</h5>
                </div>
                <div class="card-body">
                    <p><strong>Nombre:</strong> {{ $prescripcion->medicamento->nombre }}</p>
                    <p><strong>Descripción:</strong> {{ $prescripcion->medicamento->descripcion }}</p>
                    <p><strong>Dosis:</strong> {{ $prescripcion->dosis }}</p>
                </div>
            </div>
        </div>

        <!-- Observaciones -->
        <div class="col-md-12">
            <div class="card shadow-sm card-hover" style="border-top: 4px solid #12403B;">
                <div class="card-header bg-white">
                    <h5 class="card-title mb-0" style="color:#12403B;">Observaciones</h5>
                </div>
                <div class="card-body">
                    <p>{{ $prescripcion->observaciones ?? 'N/A' }}</p>
                </div>
            </div>
        </div>

        <!-- Botón Volver -->
        <div class="col-md-12 mt-3">
            <a href="{{ route('odontologo.prescripciones.index') }}" class="btn btn-secondary">
                <i class="fas fa-arrow-left"></i> Volver
            </a>
        </div>

    </div>
</div>

<style>
    /* Hover para las cards */
    .card-hover {
        transition: transform 0.3s, box-shadow 0.3s;
        cursor: pointer;
    }

    .card-hover:hover {
        transform: scale(1.02);
        box-shadow: 0 6px 15px rgba(0,0,0,0.15);
    }

    /* Responsivo */
    @media (max-width: 767px) {
        .card-hover {
            margin-bottom: 15px;
        }
    }
</style>
@endsection

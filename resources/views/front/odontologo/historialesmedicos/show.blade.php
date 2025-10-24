@extends('layouts.odontologo')

@section('title', 'Detalle del Historial Médico')

@section('content')
<div class="container">
    <h2 class="mb-4">Detalle del Historial Médico</h2>

    <div class="row g-4">

        <!-- Cita -->
        <div class="col-md-4">
            <div class="card shadow-sm" style="border-top: 4px solid #36808B;">
                <div class="card-header bg-white">
                    <h5 class="card-title mb-0" style="color:#36808B;">Cita</h5>
                </div>
                <div class="card-body">
                    @if($historial->cita)
                        <p><strong>Paciente:</strong> {{ $historial->cita->paciente->nombreCompleto() }}</p>
                        <p><strong>Servicio:</strong> {{ $historial->cita->servicio->nombre ?? 'N/A' }}</p>
                        <p><strong>Fecha:</strong> {{ \Carbon\Carbon::parse($historial->cita->horario->fecha)->format('d/m/Y') }}</p>
                        <p><strong>Hora:</strong> {{ \Carbon\Carbon::parse($historial->cita->horario->hora_inicio)->format('H:i') }}</p>
                        <p><strong>Motivo:</strong> {{ $historial->cita->motivo ?? 'Sin motivo' }}</p>
                    @else
                        <p><em>Sin cita asociada</em></p>
                    @endif
                </div>
            </div>
        </div>

        <!-- Diagnóstico -->
        <div class="col-md-4">
            <div class="card shadow-sm" style="border-top: 4px solid #5DA6A6;">
                <div class="card-header bg-white">
                    <h5 class="card-title mb-0" style="color:#5DA6A6;">Diagnóstico</h5>
                </div>
                <div class="card-body">
                    <p>{{ $historial->diagnostico }}</p>
                </div>
            </div>
        </div>

        <!-- Tratamiento -->
        <div class="col-md-4">
            <div class="card shadow-sm" style="border-top: 4px solid #12403B;">
                <div class="card-header bg-white">
                    <h5 class="card-title mb-0" style="color:#12403B;">Tratamiento</h5>
                </div>
                <div class="card-body">
                    <p>{{ $historial->tratamiento ?? 'N/A' }}</p>
                </div>
            </div>
        </div>

        <!-- Observaciones del Paciente -->
        <div class="col-md-12">
            <div class="card shadow-sm" style="border-top: 4px solid #1A1D22;">
                <div class="card-header bg-white">
                    <h5 class="card-title mb-0" style="color:#1A1D22;">Observaciones del Paciente</h5>
                </div>
                <div class="card-body">
                    <p>{{ $historial->observaciones_paciente ?? 'N/A' }}</p>
                </div>
            </div>
        </div>

        <!-- Archivo -->
        <div class="col-md-12">
            <div class="card shadow-sm" style="border-top: 4px solid #36808B;">
                <div class="card-header bg-white">
                    <h5 class="card-title mb-0" style="color:#36808B;">Archivo</h5>
                </div>
                <div class="card-body">
                    @if($historial->archivo_path)
                        <p>
                            <a href="{{ asset('storage/'.$historial->archivo_path) }}" target="_blank" style="color:#36808B; text-decoration: underline;">
                                {{ $historial->archivo_nombre_original ?? 'Archivo' }}
                            </a>
                        </p>
                    @else
                        <p>N/A</p>
                    @endif
                </div>
            </div>
        </div>

        <!-- Botones -->
        <div class="col-md-12 mt-3 d-flex justify-content-between">
            <a href="{{ route('odontologo.historialesmedicos.index') }}" class="btn btn-secondary">
                <i class="fas fa-arrow-left"></i> Volver
            </a>

            <a href="{{ route('odontologo.historialesmedicos.pdf', $historial->id) }}" class="btn btn-primary">
                <i class="fas fa-file-pdf"></i> Descargar PDF
            </a>
        </div>
    </div>
</div>
@endsection

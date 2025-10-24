@extends('adminlte::page')

@section('title', 'Prescripción Médica')

@section('content_header')
    <h1><b>Prescripciones / Detalle</b></h1>
    <hr>
@stop

@section('content')
<div class="row">
    <div class="col-md-12">

        <div class="card card-outline card-primary">
            <div class="card-header">
                <h3 class="card-title">Detalles de la prescripción</h3>
            </div>
            <div class="card-body">
                <!-- Paciente -->
                <p><strong>Paciente:</strong> {{ $prescripcion->historial->paciente->nombres ?? '-' }} {{ $prescripcion->historial->paciente->apellidos ?? '-' }}</p>

                <!-- Historial -->
                <p><strong>Historial Médico ID:</strong> {{ $prescripcion->historial->id ?? '-' }}</p>

                <!-- Medicamento -->
                <p><strong>Medicamento:</strong> {{ $prescripcion->medicamento->nombre ?? '-' }}</p>

                <!-- Dosis -->
                <p><strong>Dosis:</strong> {{ $prescripcion->dosis }}</p>

                <!-- Observaciones -->
                <p><strong>Observaciones:</strong> {{ $prescripcion->observaciones ?? '-' }}</p>

                <!-- Botón para descargar PDF -->
                <p>
                    <a href="{{ route('admin.prescripciones.pdf', $prescripcion->id) }}" 
                        class="btn btn-primary" 
                        target="_blank">
                            <i class="fas fa-file-pdf"></i> Descargar PDF
                        </a>
                </p>
            </div>
        </div>

        <!-- Botón Volver -->
        <div class="mb-2">
            <a href="{{ route('admin.prescripciones.index') }}" class="btn btn-secondary">
                <i class="fas fa-arrow-left"></i> Volver
            </a>
        </div>
    </div>
</div>
@stop

@section('js')
@if(session('success'))
Swal.fire({
    icon: 'success',
    title: '¡Éxito!',
    text: '{{ session('success') }}',
    timer: 2500,
    showConfirmButton: false
});
@endif
@stop

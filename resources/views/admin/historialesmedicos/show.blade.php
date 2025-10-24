@extends('adminlte::page')

@section('title', 'Historial Médico')

@section('content_header')
    <h1><b>Historial Médico / Detalle</b></h1>
    <hr>
@stop

@section('content')
<div class="row">
    <div class="col-md-12">

        <div class="card card-outline card-primary">
            <div class="card-header">
                <h3 class="card-title">Detalles del historial médico</h3>
            </div>
            <div class="card-body">
                <!-- Paciente -->
                <p><strong>Paciente:</strong> {{ $historial->paciente->nombres ?? '-' }} {{ $historial->paciente->apellidos ?? '-' }}</p>

                <!-- Cita -->
                @if($historial->cita)
                    <p>
                        <strong>Cita:</strong> 
                        {{ \Carbon\Carbon::parse($historial->cita->horario->fecha)->format('d/m/Y') }} 
                        ({{ $historial->cita->horario->hora_inicio }} - {{ $historial->cita->horario->hora_fin }}) - 
                        Dr(a). {{ $historial->cita->odontologo->nombres ?? '-' }} {{ $historial->cita->odontologo->apellidos ?? '' }}
                    </p>
                @else
                    <p><strong>Cita:</strong> Sin cita asociada</p>
                @endif

                <!-- Diagnóstico -->
                <p><strong>Diagnóstico:</strong></p>
                <p>{{ $historial->diagnostico }}</p>

                <!-- Tratamiento -->
                <p><strong>Tratamiento:</strong></p>
                <p>{{ $historial->tratamiento ?? '-' }}</p>

                <!-- Observaciones del paciente -->
                <p><strong>Observaciones del paciente:</strong></p>
                <p>{{ $historial->observaciones_paciente ?? '-' }}</p>

                <!-- Archivo adjunto -->
                <p>
                    <strong>Archivo adjunto:</strong>
                    @if($historial->archivo_path)
                        <a href="{{ route('admin.historialmedico.download', $historial->id) }}" 
                           class="btn btn-info btn-sm" 
                           onclick="descargandoArchivo(event)">
                            <i class="fas fa-download"></i> Descargar archivo
                        </a>
                    @else
                        No hay archivo
                    @endif
                </p>

                <!-- Botón para descargar PDF del historial -->
                <p>
                    <a href="{{ route('admin.historialesmedicos.pdf', $historial->id) }}" 
                       class="btn btn-primary" 
                       onclick="descargandoPDF(event)">
                        <i class="fas fa-file-pdf"></i> Descargar Historial PDF
                    </a>
                </p>
            </div>
        </div>

        <!-- Botón volver debajo del card -->
        <div class="mt-2 text-left">
            <a href="{{ route('admin.historialmedico.index') }}" class="btn btn-secondary">
                <i class="fas fa-arrow-left"></i> Volver
            </a>
        </div>

    </div>
</div>
@stop

@section('js')
<script>
function descargandoArchivo(event) {
    event.preventDefault();
    const url = event.currentTarget.href;

    Swal.fire({
        icon: 'info',
        title: 'Iniciando descarga...',
        timer: 1500,
        showConfirmButton: false,
        willClose: () => { window.location.href = url; }
    });
}

function descargandoPDF(event) {
    event.preventDefault();
    const url = event.currentTarget.href;

    Swal.fire({
        icon: 'info',
        title: 'Generando PDF...',
        timer: 1500,
        showConfirmButton: false,
        willClose: () => { window.location.href = url; }
    });
}

@if(session('success'))
Swal.fire({
    icon: 'success',
    title: '¡Éxito!',
    text: '{{ session('success') }}',
    timer: 2500,
    showConfirmButton: false
});
@endif

@if(session('error'))
Swal.fire({
    icon: 'error',
    title: '¡Error!',
    text: '{{ session('error') }}',
    timer: 2500,
    showConfirmButton: false
});
@endif
</script>
@stop

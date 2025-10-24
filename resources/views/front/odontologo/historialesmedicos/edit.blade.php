@extends('layouts.odontologo')

@section('title', 'Editar Historial Médico')
@section('title-section', 'Editar Historial Médico')

@section('content')
<div class="container my-4">
    <form action="{{ route('odontologo.historialesmedicos.update', $historial->id) }}" method="POST" enctype="multipart/form-data">
        @csrf
        @method('PUT')

        <div class="row">

            <!-- Cita (solo mostrar, no editable) -->
            <div class="col-md-12 mb-3">
                <div class="card shadow-sm" style="border-left: 5px solid #36808B; background-color:#f8f9fa;">
                    <div class="card-body">
                        <h5 class="card-title field-title">Cita</h5>
                        @if($historial->cita)
                            <p>
                                <strong>Paciente:</strong> {{ $historial->cita->paciente->nombreCompleto() }} <br>
                                <strong>Servicio:</strong> {{ $historial->cita->servicio->nombre ?? 'N/A' }} <br>
                                <strong>Fecha:</strong> {{ \Carbon\Carbon::parse($historial->cita->horario->fecha)->format('d/m/Y') }} <br>
                                <strong>Hora:</strong> {{ \Carbon\Carbon::parse($historial->cita->horario->hora_inicio)->format('H:i') }} <br>
                                <strong>Motivo:</strong> {{ $historial->cita->motivo ?? 'Sin motivo' }}
                            </p>
                        @else
                            <p><em>Sin cita asociada</em></p>
                        @endif
                    </div>
                </div>
            </div>

            <!-- Diagnóstico -->
            <div class="col-md-6 mb-3">
                <div class="card shadow-sm card-hover" style="border-left: 5px solid #5DA6A6;">
                    <div class="card-body">
                        <h5 class="card-title field-title">Diagnóstico</h5>
                        <textarea name="diagnostico" class="form-control" rows="3" required>{{ old('diagnostico', $historial->diagnostico) }}</textarea>
                        @error('diagnostico') <small class="text-danger">{{ $message }}</small> @enderror
                    </div>
                </div>
            </div>

            <!-- Tratamiento -->
            <div class="col-md-6 mb-3">
                <div class="card shadow-sm card-hover" style="border-left: 5px solid #12403B;">
                    <div class="card-body">
                        <h5 class="card-title field-title">Tratamiento</h5>
                        <textarea name="tratamiento" class="form-control" rows="3">{{ old('tratamiento', $historial->tratamiento) }}</textarea>
                        @error('tratamiento') <small class="text-danger">{{ $message }}</small> @enderror
                    </div>
                </div>
            </div>

            <!-- Observaciones del Paciente -->
            <div class="col-md-12 mb-3">
                <div class="card shadow-sm card-hover" style="border-left: 5px solid #1A1D22;">
                    <div class="card-body">
                        <h5 class="card-title field-title">Observaciones del Paciente</h5>
                        <textarea name="observaciones_paciente" class="form-control" rows="3">{{ old('observaciones_paciente', $historial->observaciones_paciente) }}</textarea>
                        @error('observaciones_paciente') <small class="text-danger">{{ $message }}</small> @enderror
                    </div>
                </div>
            </div>

            <!-- Archivo -->
            <div class="col-md-12 mb-4">
                <div class="card shadow-sm card-hover" style="border-left: 5px solid #36808B;">
                    <div class="card-body">
                        <h5 class="card-title field-title">Archivo</h5>
                        <input type="file" name="archivo" class="form-control" accept=".pdf,.jpg,.png,.jpeg,.doc,.docx">

                        @if($historial->archivo_path)
                            <p class="mt-2">
                                Archivo actual: 
                                <a href="{{ asset('storage/'.$historial->archivo_path) }}" target="_blank">
                                    {{ $historial->archivo_nombre_original ?? 'Archivo' }}
                                </a>
                            </p>
                        @endif
                        @error('archivo') <small class="text-danger">{{ $message }}</small> @enderror
                    </div>
                </div>
            </div>

        </div>

        <!-- Botones -->
        <div class="d-flex justify-content-start flex-wrap gap-2 mt-3">
            <button type="submit" class="btn" style="background-color:#36808B; color:#ffffff;">
                <i class="fas fa-save"></i> Actualizar Historial
            </button>
            <a href="{{ route('odontologo.historialesmedicos.index') }}" class="btn btn-secondary">Cancelar</a>
        </div>

    </form>
</div>

<style>
    .field-title {
        font-size: 1.3rem;
        font-weight: 700;
        color: #12403B;
        font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
        letter-spacing: 0.5px;
        margin-bottom: 10px;
    }

    .card-hover {
        transition: transform 0.3s, box-shadow 0.3s;
        cursor: pointer;
    }

    .card-hover:hover {
        transform: scale(1.02);
        box-shadow: 0 6px 15px rgba(0,0,0,0.15);
    }

    @media (max-width: 767px) {
        .card-hover {
            margin-bottom: 15px;
        }
    }
</style>
@endsection

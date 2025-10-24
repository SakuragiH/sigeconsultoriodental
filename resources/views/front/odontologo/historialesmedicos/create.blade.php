@extends('layouts.odontologo')

@section('title', 'Nuevo Historial Médico')
@section('title-section', 'Registrar Historial Médico')

@section('content')
<div class="container my-4">
    <form action="{{ route('odontologo.historialesmedicos.store') }}" method="POST" enctype="multipart/form-data">
        @csrf

        <div class="row">

            <!-- Seleccionar Cita -->
            <div class="col-md-12 mb-3">
                <div class="card shadow-sm card-hover" style="border-left: 5px solid #36808B;">
                    <div class="card-body">
                        <h5 class="card-title field-title">Cita</h5>
                        <select name="cita_id" id="cita_id" class="form-control" required>
                            <option value="">Seleccione una cita</option>
                            @foreach($citas as $cita)
                                <option value="{{ $cita->id }}">
                                    {{ $cita->paciente->nombreCompleto() ?? 'Sin nombre' }} |
                                    {{ $cita->servicio->nombre ?? 'Sin servicio' }} |
                                    {{ \Carbon\Carbon::parse($cita->horario->fecha)->format('d/m/Y') }} -
                                    {{ \Carbon\Carbon::parse($cita->horario->hora_inicio)->format('H:i') }} |
                                    {{ $cita->motivo ?? 'Sin motivo' }}
                                </option>
                            @endforeach
                        </select>
                        @error('cita_id') <small class="text-danger">{{ $message }}</small> @enderror
                    </div>
                </div>
            </div>

            <!-- Diagnóstico -->
            <div class="col-md-6 mb-3">
                <div class="card shadow-sm card-hover" style="border-left: 5px solid #5DA6A6;">
                    <div class="card-body">
                        <h5 class="card-title field-title">Diagnóstico</h5>
                        <textarea name="diagnostico" id="diagnostico" class="form-control" rows="3" required>{{ old('diagnostico') }}</textarea>
                        @error('diagnostico') <small class="text-danger">{{ $message }}</small> @enderror
                    </div>
                </div>
            </div>

            <!-- Tratamiento -->
            <div class="col-md-6 mb-3">
                <div class="card shadow-sm card-hover" style="border-left: 5px solid #12403B;">
                    <div class="card-body">
                        <h5 class="card-title field-title">Tratamiento</h5>
                        <textarea name="tratamiento" id="tratamiento" class="form-control" rows="3">{{ old('tratamiento') }}</textarea>
                        @error('tratamiento') <small class="text-danger">{{ $message }}</small> @enderror
                    </div>
                </div>
            </div>

            <!-- Observaciones del Paciente -->
            <div class="col-md-12 mb-3">
                <div class="card shadow-sm card-hover" style="border-left: 5px solid #1A1D22;">
                    <div class="card-body">
                        <h5 class="card-title field-title">Observaciones del Paciente</h5>
                        <textarea name="observaciones_paciente" id="observaciones_paciente" class="form-control" rows="3">{{ old('observaciones_paciente') }}</textarea>
                        @error('observaciones_paciente') <small class="text-danger">{{ $message }}</small> @enderror
                    </div>
                </div>
            </div>

            <!-- Subir Archivo -->
            <div class="col-md-12 mb-4">
                <div class="card shadow-sm card-hover" style="border-left: 5px solid #36808B;">
                    <div class="card-body">
                        <h5 class="card-title field-title">Archivo (opcional)</h5>
                        <input type="file" name="archivo" id="archivo" class="form-control" accept=".pdf,.jpg,.png,.jpeg,.doc,.docx">
                        @error('archivo') <small class="text-danger">{{ $message }}</small> @enderror
                    </div>
                </div>
            </div>

        </div>

        <!-- Botones -->
        <div class="d-flex justify-content-start flex-wrap gap-2 mt-3">
            <button type="submit" class="btn" style="background-color:#36808B; color:#ffffff;">
                <i class="fas fa-save"></i> Guardar Historial
            </button>
            <a href="{{ route('odontologo.historialesmedicos.index') }}" class="btn btn-secondary">Cancelar</a>
        </div>
    </form>
</div>

<style>
    /* Estilo de títulos de campos */
    .field-title {
        font-size: 1.3rem;
        font-weight: 700;
        color: #12403B;
        font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
        letter-spacing: 0.5px;
        margin-bottom: 10px;
    }

    /* Hover cards */
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

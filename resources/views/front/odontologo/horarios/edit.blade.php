@extends('layouts.odontologo')

@section('title', 'Editar Horario')
@section('title-section', 'Editar Horario')

@section('content')
<div class="container my-4">
    <form action="{{ route('odontologo.horarios.update', $horario->id) }}" method="POST">
        @csrf
        @method('PUT')

        <div class="row">
            <div class="col-md-6">
                <!-- Fecha -->
                <div class="card shadow-sm mb-3" style="border-left: 5px solid #36808B;">
                    <div class="card-body">
                        <h6 class="card-title" style="color:#12403B;">Fecha</h6>
                        <input 
                            type="date" 
                            class="form-control" 
                            name="fecha" 
                            value="{{ old('fecha', $horario->fecha) }}" 
                            required>
                        @error('fecha') <small class="text-danger">{{ $message }}</small> @enderror
                    </div>
                </div>

                <!-- Hora inicio -->
                <div class="card shadow-sm mb-3" style="border-left: 5px solid #5DA6A6;">
                    <div class="card-body">
                        <h6 class="card-title" style="color:#12403B;">Hora Inicio</h6>
                        <input 
                            type="time" 
                            class="form-control" 
                            name="hora_inicio" 
                            value="{{ old('hora_inicio', $horario->hora_inicio) }}" 
                            required>
                        @error('hora_inicio') <small class="text-danger">{{ $message }}</small> @enderror
                    </div>
                </div>

                <!-- Hora fin -->
                <div class="card shadow-sm mb-3" style="border-left: 5px solid #12403B;">
                    <div class="card-body">
                        <h6 class="card-title" style="color:#12403B;">Hora Fin</h6>
                        <input 
                            type="time" 
                            class="form-control" 
                            name="hora_fin" 
                            value="{{ old('hora_fin', $horario->hora_fin) }}" 
                            required>
                        <small class="text-muted">Los intervalos se generarán automáticamente</small>
                        @error('hora_fin') <small class="text-danger">{{ $message }}</small> @enderror
                    </div>
                </div>

                <!-- Disponibilidad -->
                    <div class="card shadow-sm mb-3" style="border-left: 5px solid #36808B;">
                        <div class="card-body">
                            <h6 class="card-title" style="color:#12403B;">Disponible</h6>
                            <select name="disponible" class="form-control">
                                <option value="1" {{ old('disponible', $horario->disponible) ? 'selected' : '' }}>Sí</option>
                                <option value="0" {{ !old('disponible', $horario->disponible) ? 'selected' : '' }}>No</option>
                            </select>
                        </div>
                    </div>


                <!-- Botones -->
                <div class="d-flex justify-content-start mt-3">
                    <button type="submit" 
                            class="btn" 
                            style="background-color:#36808B; color:#ffffff; margin-right: 10px;">
                        <i class="fas fa-save"></i> Actualizar
                    </button>
                    <a href="{{ route('odontologo.horarios') }}" 
                       class="btn" 
                       style="background-color:#1A1D22; color:#ffffff;">
                        Cancelar
                    </a>
                </div>
            </div>

            <div class="col-md-6"><!-- Espacio vacío derecho --></div>
        </div>
    </form>
</div>
@endsection

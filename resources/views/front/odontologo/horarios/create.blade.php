@extends('layouts.odontologo')

@section('title', 'Agregar Horarios Recurrentes')
@section('title-section', 'Agregar Horarios Recurrentes')

@section('content')
<div class="container my-4">
    <form action="{{ route('odontologo.horarios.guardar') }}" method="POST">
        @csrf

        <div class="row">
            <div class="col-md-6">
                <!-- Fecha de inicio -->
                <div class="card shadow-sm mb-3" style="border-left: 5px solid #36808B;">
                    <div class="card-body">
                        <h6 class="card-title" style="color:#12403B;">Fecha de Inicio</h6>
                        <input 
                            type="date" 
                            class="form-control" 
                            name="fecha_inicio" 
                            value="{{ old('fecha_inicio') }}" 
                            required>
                        @error('fecha_inicio') <small class="text-danger">{{ $message }}</small> @enderror
                    </div>
                </div>

                <!-- Fecha de fin -->
                <div class="card shadow-sm mb-3" style="border-left: 5px solid #12403B;">
                    <div class="card-body">
                        <h6 class="card-title" style="color:#12403B;">Fecha de Fin</h6>
                        <input 
                            type="date" 
                            class="form-control" 
                            name="fecha_fin" 
                            value="{{ old('fecha_fin') }}" 
                            required>
                        @error('fecha_fin') <small class="text-danger">{{ $message }}</small> @enderror
                    </div>
                </div>

                <!-- Días de la semana -->
                <div class="card shadow-sm mb-3" style="border-left: 5px solid #5DA6A6;">
                    <div class="card-body">
                        <h6 class="card-title" style="color:#12403B;">Días de la semana</h6>
                        @php
                            $dias = ['Lunes','Martes','Miércoles','Jueves','Viernes','Sábado'];
                        @endphp
                        @foreach($dias as $dia)
                            <div class="form-check">
                                <input class="form-check-input" type="checkbox" name="dias[]" value="{{ $dia }}" id="dia_{{ $dia }}">
                                <label class="form-check-label" for="dia_{{ $dia }}">{{ $dia }}</label>
                            </div>
                        @endforeach
                        @error('dias') <small class="text-danger">{{ $message }}</small> @enderror
                    </div>
                </div>

                <!-- Hora inicio -->
                <div class="card shadow-sm mb-3" style="border-left: 5px solid #36808B;">
                    <div class="card-body">
                        <h6 class="card-title" style="color:#12403B;">Hora Inicio</h6>
                        <input 
                            type="time" 
                            class="form-control" 
                            name="hora_inicio" 
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
                            required>
                        <small class="text-muted">Los intervalos se generarán automáticamente</small>
                        @error('hora_fin') <small class="text-danger">{{ $message }}</small> @enderror
                    </div>
                </div>

                <!-- Botones -->
                <div class="d-flex justify-content-start mt-3">
                    <button type="submit" 
                            class="btn" 
                            style="background-color:#36808B; color:#ffffff; margin-right: 10px;">
                        <i class="fas fa-save"></i> Crear Horarios
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

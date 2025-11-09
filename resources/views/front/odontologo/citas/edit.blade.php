@extends('layouts.odontologo')

@section('title', 'Editar Cita')

@section('content')
<div class="container">
    <h2 class="mb-4">Editar Cita</h2>

    <form action="{{ route('odontologo.citas.update', $cita->id) }}" method="POST">
        @csrf
        @method('PUT')

        <div class="row">

            <!-- Paciente -->
            <div class="col-md-6 mb-3">
                <div class="card border-primary shadow-sm">
                    <div class="card-header bg-primary text-white">
                        Paciente
                    </div>
                    <div class="card-body">
                        <select name="paciente_id" class="form-control">
                            @foreach($pacientes as $paciente)
                                <option value="{{ $paciente->id }}" 
                                    {{ $cita->paciente_id == $paciente->id ? 'selected' : '' }}>
                                    {{ $paciente->nombres }} {{ $paciente->apellidos }}
                                </option>
                            @endforeach
                        </select>
                        @error('paciente_id')
                            <small class="text-danger">{{ $message }}</small>
                        @enderror
                    </div>
                </div>
            </div>

            <!-- Servicio -->
            <div class="col-md-6 mb-3">
                <div class="card border-success shadow-sm">
                    <div class="card-header bg-success text-white">
                        Servicio
                    </div>
                    <div class="card-body">
                        <select name="servicio_id" class="form-control">
                            @foreach($servicios as $servicio)
                                <option value="{{ $servicio->id }}" 
                                    {{ $cita->servicio_id == $servicio->id ? 'selected' : '' }}>
                                    {{ $servicio->nombre }}
                                </option>
                            @endforeach
                        </select>
                        @error('servicio_id')
                            <small class="text-danger">{{ $message }}</small>
                        @enderror
                    </div>
                </div>
            </div>

            <!-- Horario -->
            <div class="col-md-6 mb-3">
                <div class="card border-info shadow-sm">
                    <div class="card-header bg-info text-white">
                        Horario
                    </div>
                    <div class="card-body">
                        <select name="horario_id" class="form-control">
                            @foreach($horarios as $horario)
                                <option value="{{ $horario->id }}" 
                                    {{ $cita->horario_id == $horario->id ? 'selected' : '' }}>
                                    {{ $horario->fecha }} - {{ $horario->hora_inicio }} a {{ $horario->hora_fin }}
                                </option>
                            @endforeach
                        </select>
                        @error('horario_id')
                            <small class="text-danger">{{ $message }}</small>
                        @enderror
                    </div>
                </div>
            </div>

            <!-- Motivo -->
            <div class="col-md-6 mb-3">
                <div class="card border-warning shadow-sm">
                    <div class="card-header bg-warning text-white">
                        Motivo
                    </div>
                    <div class="card-body">
                        <textarea name="motivo" class="form-control" rows="3">{{ old('motivo', $cita->motivo) }}</textarea>
                        @error('motivo')
                            <small class="text-danger">{{ $message }}</small>
                        @enderror
                    </div>
                </div>
            </div>

            <!-- Observaciones -->
            <div class="col-md-6 mb-3">
                <div class="card border-secondary shadow-sm">
                    <div class="card-header bg-secondary text-white">
                        Observaciones
                    </div>
                    <div class="card-body">
                        <textarea name="observaciones" class="form-control" rows="3">{{ old('observaciones', $cita->observaciones) }}</textarea>
                        @error('observaciones')
                            <small class="text-danger">{{ $message }}</small>
                        @enderror
                    </div>
                </div>
            </div>

            <!-- Estado -->
            <div class="col-md-6 mb-3">
                <div class="card border-dark shadow-sm">
                    <div class="card-header bg-dark text-white">
                        Estado
                    </div>
                    <div class="card-body">
                        <select name="estado" class="form-control">
                            <option value="Pendiente" {{ $cita->estado == 'Pendiente' ? 'selected' : '' }}>Pendiente</option>
                            <option value="Confirmada" {{ $cita->estado == 'Confirmada' ? 'selected' : '' }}>Confirmada</option>
                            <option value="Cancelada" {{ $cita->estado == 'Cancelada' ? 'selected' : '' }}>Cancelada</option>
                            <option value="Realizada" {{ $cita->estado == 'Realizada' ? 'selected' : '' }}>Realizada</option>
                        </select>
                        @error('estado')
                            <small class="text-danger">{{ $message }}</small>
                        @enderror
                    </div>
                </div>
            </div>

        </div>

        <div class="mt-4">
            <button type="submit" class="btn btn-primary"><i class="fas fa-save"></i> Guardar Cambios</button>
            <a href="{{ route('odontologo.citas.index') }}" class="btn btn-secondary"><i class="fas fa-arrow-left"></i> Volver</a>
        </div>
    </form>
</div>
@endsection

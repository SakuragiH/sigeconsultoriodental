@extends('adminlte::page')

@section('title', 'Editar Cita')

@section('content_header')
    <h1><b>Editar Cita</b></h1>
    <hr>
@stop

@section('content')
<div class="row">
    <div class="col-md-12">
        <div class="card card-primary">
            <div class="card-header">
                <h3 class="card-title">Actualice los datos de la cita</h3>
            </div>
            <div class="card-body">
                {{-- Enviamos odontologo_id por GET al cambiar odontólogo --}}
                <form action="{{ route('admin.citas.update', $cita->id) }}" method="POST">
                    @csrf
                    @method('PUT')

                    <div class="row">
                        <!-- Paciente -->
                        <div class="col-md-6">
                            <label>Paciente</label>
                            <select name="paciente_id" class="form-control" required>
                                <option value="">Seleccione paciente...</option>
                                @foreach($pacientes as $paciente)
                                    <option value="{{ $paciente->id }}" 
                                        {{ $cita->paciente_id == $paciente->id ? 'selected' : '' }}>
                                        {{ $paciente->nombres }} {{ $paciente->apellidos }}
                                    </option>
                                @endforeach
                            </select>
                        </div>

                        <!-- Odontólogo -->
                        <div class="col-md-6">
                            <label>Odontólogo</label>
                            <select name="odontologo_id" class="form-control" 
                                onchange="window.location='?odontologo_id='+this.value">
                                <option value="">Seleccione odontólogo...</option>
                                @foreach($odontologos as $odontologo)
                                    <option value="{{ $odontologo->id }}" 
                                        {{ $odontologoSeleccionado == $odontologo->id ? 'selected' : '' }}>
                                        {{ $odontologo->nombres }} {{ $odontologo->apellidos }}
                                    </option>
                                @endforeach
                            </select>
                        </div>
                    </div>

                    <div class="row mt-2">
                        <!-- Servicio -->
                        <div class="col-md-6">
                            <label>Servicio</label>
                            <select name="servicio_id" class="form-control" required>
                                <option value="">Seleccione servicio...</option>
                                @foreach($servicios as $servicio)
                                    <option value="{{ $servicio->id }}" 
                                        {{ $cita->servicio_id == $servicio->id ? 'selected' : '' }}>
                                        {{ $servicio->nombre }}
                                    </option>
                                @endforeach
                            </select>
                        </div>

                        <!-- Horario -->
                        <div class="col-md-6">
                            <label>Horario</label>
                            <select name="horario_id" class="form-control" required>
                                <option value="">Seleccione horario...</option>
                                @foreach($horarios as $horario)
                                    <option value="{{ $horario->id }}" 
                                        {{ $cita->horario_id == $horario->id ? 'selected' : '' }}>
                                        {{ \Carbon\Carbon::parse($horario->fecha)->format('d/m/Y') }} - 
                                        {{ \Carbon\Carbon::parse($horario->hora_inicio)->format('h:i A') }} 
                                        a {{ \Carbon\Carbon::parse($horario->hora_fin)->format('h:i A') }}
                                    </option>
                                @endforeach
                            </select>
                        </div>
                    </div>

                    <div class="row mt-2">
                        <!-- Motivo -->
                        <div class="col-md-6">
                            <label>Motivo</label>
                            <textarea name="motivo" class="form-control">{{ old('motivo', $cita->motivo) }}</textarea>
                        </div>

                        <!-- Observaciones -->
                        <div class="col-md-6">
                            <label>Observaciones</label>
                            <textarea name="observaciones" class="form-control">{{ old('observaciones', $cita->observaciones) }}</textarea>
                        </div>
                    </div>

                    <hr>
                    <button type="submit" class="btn btn-primary">Actualizar</button>
                    <a href="{{ route('admin.citas.index') }}" class="btn btn-secondary">Cancelar</a>
                </form>
            </div>
        </div>
    </div>
</div>
@stop

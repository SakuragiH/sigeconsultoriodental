@extends('adminlte::page')

@section('content_header')
    <h1><b>Historial Médico / Registro de un nuevo historial</b></h1>
    <hr>
@stop

@section('content')
<div class="row">
    <div class="col-md-12">
        <div class="card card-primary">
            <div class="card-header">
                <h3 class="card-title">Llene los datos del historial</h3>
            </div>
            <div class="card-body">
                <form action="{{ route('admin.historialmedico.store') }}" method="post" enctype="multipart/form-data">
                    @csrf
                    <div class="row">
                        <!-- PACIENTE -->
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="paciente_id">Paciente</label><b> (*)</b>
                                <select name="paciente_id" class="form-control" required>
                                    <option value="">Seleccione paciente...</option>
                                    @foreach($pacientes as $paciente)
                                        <option value="{{ $paciente->id }}" {{ old('paciente_id') == $paciente->id ? 'selected' : '' }}>
                                            {{ $paciente->nombres }} {{ $paciente->apellidos }}
                                        </option>
                                    @endforeach
                                </select>
                                @error('paciente_id')
                                    <small style="color: red">{{ $message }}</small>
                                @enderror
                            </div>
                        </div>

                        <!-- CITA -->
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="cita_id">Cita (opcional)</label>
                                <select name="cita_id" class="form-control">
                                    <option value="">Sin cita</option>
                                    @foreach($citas as $cita)
                                        <option value="{{ $cita->id }}" {{ old('cita_id') == $cita->id ? 'selected' : '' }}>
                                            {{ $cita->paciente->nombres ?? '-' }} {{ $cita->paciente->apellidos ?? '' }} - 
                                            {{ \Carbon\Carbon::parse($cita->horario->fecha)->format('d/m/Y') }} 
                                            ({{ $cita->horario->hora_inicio }} - {{ $cita->horario->hora_fin }}) - 
                                            Dr(a). {{ $cita->odontologo->nombres ?? '' }}
                                        </option>
                                    @endforeach
                                </select>
                                @error('cita_id')
                                    <small style="color: red">{{ $message }}</small>
                                @enderror
                            </div>
                        </div>
                    </div>

                    <div class="row">
                        <!-- DIAGNÓSTICO -->
                        <div class="col-md-12">
                            <div class="form-group">
                                <label for="diagnostico">Diagnóstico</label><b> (*)</b>
                                <textarea name="diagnostico" class="form-control" rows="3" placeholder="Ingrese diagnóstico..." required>{{ old('diagnostico') }}</textarea>
                                @error('diagnostico')
                                    <small style="color: red">{{ $message }}</small>
                                @enderror
                            </div>
                        </div>

                        <!-- TRATAMIENTO -->
                        <div class="col-md-12">
                            <div class="form-group">
                                <label for="tratamiento">Tratamiento</label>
                                <textarea name="tratamiento" class="form-control" rows="3" placeholder="Ingrese tratamiento...">{{ old('tratamiento') }}</textarea>
                                @error('tratamiento')
                                    <small style="color: red">{{ $message }}</small>
                                @enderror
                            </div>
                        </div>

                        <!-- OBSERVACIONES PACIENTE -->
                        <div class="col-md-12">
                            <div class="form-group">
                                <label for="observaciones_paciente">Observaciones del Paciente</label>
                                <textarea name="observaciones_paciente" class="form-control" rows="2" placeholder="Ingrese observaciones del paciente...">{{ old('observaciones_paciente') }}</textarea>
                                @error('observaciones_paciente')
                                    <small style="color: red">{{ $message }}</small>
                                @enderror
                            </div>
                        </div>

                        <!-- ARCHIVO -->
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="archivo">Adjuntar archivo (PDF, imagen)</label>
                                <div class="input-group mb-3">
                                    <div class="input-group-prepend">
                                        <span class="input-group-text"><i class="fas fa-file-upload"></i></span>
                                    </div>
                                    <input type="file" name="archivo" id="archivoInput" class="form-control">
                                </div>
                                <small class="text-muted">Opcional. Tamaño máximo: 5MB.</small>
                                <img id="previewArchivo" src="#" alt="Vista previa" style="max-width:200px; display:none; margin-top:10px; border-radius:5px;">
                                @error('archivo')
                                    <small style="color: red">{{ $message }}</small>
                                @enderror
                            </div>
                        </div>
                    </div>

                    <hr>
                    <div class="row">
                        <div class="col-md-12">
                            <div class="form-group">
                                <button type="submit" class="btn btn-primary">Registrar Historial</button>
                                <a href="{{ route('admin.historialmedico.index') }}" class="btn btn-secondary">Cancelar</a>
                            </div>
                        </div>
                    </div>

                </form>
            </div>
        </div>
    </div>
</div>
@stop

@section('js')
<script>
    document.getElementById('archivoInput').addEventListener('change', function(event) {
        const [file] = event.target.files;
        if (file && file.type.startsWith('image/')) {
            const preview = document.getElementById('previewArchivo');
            preview.src = URL.createObjectURL(file);
            preview.style.display = 'block';
        } else {
            document.getElementById('previewArchivo').style.display = 'none';
        }
    });
</script>

@if(session('success'))
<div class="alert alert-success alert-dismissible fade show" role="alert">
    {{ session('success') }}
    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
</div>
@endif
@stop

@extends('adminlte::page')

@section('title', 'Editar Historial Médico')

@section('content_header')
    <h1><b>Historial Médico / Editar</b></h1>
    <hr>
@stop

@section('content')
<div class="row">
    <div class="col-md-12">
        <div class="card card-primary">
            <div class="card-header">
                <h3 class="card-title">Actualizar datos del historial</h3>
            </div>
            <div class="card-body">
                <form action="{{ route('admin.historialmedico.update', $historial->id) }}" method="post" enctype="multipart/form-data">
                    @csrf
                    @method('PUT')

                    <div class="row">
                        <!-- PACIENTE -->
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="paciente_id">Paciente</label><b> (*)</b>
                                <select name="paciente_id" class="form-control" required>
                                    <option value="">Seleccione paciente...</option>
                                    @foreach($pacientes as $paciente)
                                        <option value="{{ $paciente->id }}" {{ $historial->paciente_id == $paciente->id ? 'selected' : '' }}>
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
                                        <option value="{{ $cita->id }}" {{ $historial->cita_id == $cita->id ? 'selected' : '' }}>
                                            {{ \Carbon\Carbon::parse($cita->horario->fecha)->format('d/m/Y') }} - {{ $cita->horario->hora_inicio }}
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
                                <textarea name="diagnostico" class="form-control" rows="3" required>{{ old('diagnostico', $historial->diagnostico) }}</textarea>
                                @error('diagnostico')
                                    <small style="color: red">{{ $message }}</small>
                                @enderror
                            </div>
                        </div>

                        <!-- TRATAMIENTO -->
                        <div class="col-md-12">
                            <div class="form-group">
                                <label for="tratamiento">Tratamiento</label>
                                <textarea name="tratamiento" class="form-control" rows="3">{{ old('tratamiento', $historial->tratamiento) }}</textarea>
                                @error('tratamiento')
                                    <small style="color: red">{{ $message }}</small>
                                @enderror
                            </div>
                        </div>

                        <!-- OBSERVACIONES PACIENTE -->
                        <div class="col-md-12">
                            <div class="form-group">
                                <label for="observaciones_paciente">Observaciones del Paciente</label>
                                <textarea name="observaciones_paciente" class="form-control" rows="2">{{ old('observaciones_paciente', $historial->observaciones_paciente) }}</textarea>
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
                                @if($historial->archivo_path)
                                    <p>Archivo actual: {{ $historial->archivo_nombre_original }}</p>
                                    <a href="{{ route('admin.historialmedico.download', $historial->id) }}" class="btn btn-info btn-sm">
                                        Descargar archivo actual
                                    </a>
                                @endif
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
                                <button type="submit" class="btn btn-primary">Actualizar Historial</button>
                                <a href="{{ route('admin.historialmedico.show', $historial->id) }}" class="btn btn-secondary">Cancelar</a>
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
@stop

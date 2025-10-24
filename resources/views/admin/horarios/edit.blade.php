@extends('adminlte::page')

@section('content_header')
    <h1><b>Horarios / Editar horario</b></h1>
    <hr>
@stop

@section('content')
<div class="row">
    <div class="col-md-12">
        <div class="card card-primary">
            <div class="card-header">
                <h3 class="card-title">Actualice los datos del horario</h3>
            </div>
            <div class="card-body">
                <form action="{{ route('admin.horarios.update', $horario->id) }}" method="post">
                    @csrf
                    @method('PUT')

                    <div class="row">
                        <!-- ODONTOLOGO -->
                        <div class="col-md-4">
                            <div class="form-group">
                                <label for="odontologo_id">Odontólogo</label><b> (*)</b>
                                <select name="odontologo_id" class="form-control" required>
                                    <option value="">Seleccione odontólogo...</option>
                                    @foreach($odontologos as $odontologo)
                                        <option value="{{ $odontologo->id }}" {{ old('odontologo_id', $horario->odontologo_id) == $odontologo->id ? 'selected' : '' }}>
                                            {{ $odontologo->nombres }} {{ $odontologo->apellidos }}
                                        </option>
                                    @endforeach
                                </select>
                                @error('odontologo_id')
                                    <small style="color: red">{{ $message }}</small>
                                @enderror
                            </div>
                        </div>

                        <!-- FECHA -->
                        <div class="col-md-4">
                            <div class="form-group">
                                <label for="fecha">Fecha</label><b> (*)</b>
                                <input type="date" name="fecha" id="fecha" class="form-control" 
                                       value="{{ old('fecha', $horario->fecha) }}" required>
                                @error('fecha')
                                    <small style="color: red">{{ $message }}</small>
                                @enderror
                            </div>
                        </div>

                        <!-- DÍA (auto calculado) -->
                        <div class="col-md-4">
                            <div class="form-group">
                                <label for="dia">Día de la semana</label>
                                <input type="text" id="dia" name="dia" class="form-control" 
                                       value="{{ old('dia', $horario->dia) }}" readonly>
                                <small>Se calculará automáticamente al seleccionar la fecha</small>
                            </div>
                        </div>
                    </div>

                    <div class="row">
                        <!-- HORA INICIO -->
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="hora_inicio">Hora de inicio</label><b> (*)</b>
                                <input type="time" name="hora_inicio" class="form-control" 
                                       value="{{ old('hora_inicio', $horario->hora_inicio) }}" required>
                                @error('hora_inicio')
                                    <small style="color: red">{{ $message }}</small>
                                @enderror
                            </div>
                        </div>

                        <!-- HORA FIN -->
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="hora_fin">Hora fin</label><b> (*)</b>
                                <input type="time" name="hora_fin" class="form-control" 
                                       value="{{ old('hora_fin', $horario->hora_fin) }}" required>
                                @error('hora_fin')
                                    <small style="color: red">{{ $message }}</small>
                                @enderror
                            </div>
                        </div>
                    </div>

                    <div class="row">
                        <!-- DISPONIBLE -->
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="disponible">Disponible</label><b> (*)</b>
                                <select name="disponible" class="form-control" required>
                                    <option value="1" {{ old('disponible', $horario->disponible) == 1 ? 'selected' : '' }}>Sí</option>
                                    <option value="0" {{ old('disponible', $horario->disponible) == 0 ? 'selected' : '' }}>No</option>
                                </select>
                                @error('disponible')
                                    <small style="color: red">{{ $message }}</small>
                                @enderror
                            </div>
                        </div>
                    </div>

                    <hr>
                    <div class="row">
                        <div class="col-md-12">
                            <div class="form-group">
                                <button type="submit" class="btn btn-primary">Actualizar</button>
                                <a href="{{ route('admin.horarios.index') }}" class="btn btn-secondary">Cancelar</a>
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
    // Calcula automáticamente el día de la semana al elegir la fecha
    document.getElementById('fecha').addEventListener('change', function() {
        const dias = ['Domingo','Lunes','Martes','Miércoles','Jueves','Viernes','Sábado'];
        const fecha = new Date(this.value);
        document.getElementById('dia').value = dias[fecha.getDay()];
    });

    @if(session('success'))
    Swal.fire({
        icon: 'success',
        title: '¡Éxito!',
        text: '{{ session('success') }}',
        timer: 2500,
        showConfirmButton: false
    });
    @endif
</script>
@stop

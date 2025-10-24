@extends('layouts.odontologo')

@section('title', 'Crear Cita')

@section('content')
<div class="container">
    <h2 class="mb-4">Crear Nueva Cita</h2>

    <form action="{{ route('odontologo.citas.store') }}" method="POST">
        @csrf

        <div class="row">

            <!-- Paciente -->
            <div class="col-md-6 mb-3">
                <div class="card" style="background-color:#36808B; color:white;">
                    <div class="card-header" style="font-size:1.3rem; font-weight:bold; letter-spacing:1px;">Paciente</div>
                    <div class="card-body">
                        <select name="paciente_id" class="form-control select2">
                            <option value="">-- Seleccione Paciente --</option>
                        </select>
                        @error('paciente_id') <small class="text-danger">{{ $message }}</small> @enderror
                    </div>
                </div>
            </div>

            <!-- Servicio -->
            <div class="col-md-6 mb-3">
                <div class="card" style="background-color:#5DA6A6; color:white;">
                    <div class="card-header" style="font-size:1.3rem; font-weight:bold; letter-spacing:1px;">Servicio</div>
                    <div class="card-body">
                        <select name="servicio_id" class="form-control">
                            <option value="">-- Seleccione Servicio --</option>
                            @foreach($servicios as $servicio)
                                <option value="{{ $servicio->id }}">{{ $servicio->nombre }}</option>
                            @endforeach
                        </select>
                        @error('servicio_id') <small class="text-danger">{{ $message }}</small> @enderror
                    </div>
                </div>
            </div>

            <!-- Horario -->
            <div class="col-md-6 mb-3">
                <div class="card" style="background-color:#12403B; color:white;">
                    <div class="card-header" style="font-size:1.3rem; font-weight:bold; letter-spacing:1px;">Horario Disponible</div>
                    <div class="card-body">
                        <select name="horario_id" class="form-control">
                            <option value="">-- Seleccione Horario --</option>
                            @foreach($horarios as $horario)
                                <option value="{{ $horario->id }}">
                                    {{ $horario->fecha }} | {{ $horario->hora_inicio }} - {{ $horario->hora_fin }}
                                </option>
                            @endforeach
                        </select>
                        @error('horario_id') <small class="text-danger">{{ $message }}</small> @enderror
                    </div>
                </div>
            </div>

            <!-- Motivo -->
            <div class="col-md-6 mb-3">
                <div class="card" style="background-color:#1A1D22; color:white;">
                    <div class="card-header" style="font-size:1.3rem; font-weight:bold; letter-spacing:1px;">Motivo de la Cita</div>
                    <div class="card-body">
                        <textarea name="motivo" class="form-control" rows="3">{{ old('motivo') }}</textarea>
                        @error('motivo') <small class="text-danger">{{ $message }}</small> @enderror
                    </div>
                </div>
            </div>

            <!-- Observaciones -->
            <div class="col-md-12 mb-3">
                <div class="card" style="background-color:#ffffff; color:#1A1D22;">
                    <div class="card-header" style="font-size:1.3rem; font-weight:bold; letter-spacing:1px;">Observaciones</div>
                    <div class="card-body">
                        <textarea name="observaciones" class="form-control" rows="3">{{ old('observaciones') }}</textarea>
                        @error('observaciones') <small class="text-danger">{{ $message }}</small> @enderror
                    </div>
                </div>
            </div>

        </div>

        <button type="submit" class="btn btn-primary mt-3">Guardar Cita</button>
        <a href="{{ route('odontologo.citas.index') }}" class="btn btn-secondary mt-3">Cancelar</a>

    </form>
</div>
@endsection

@push('styles')
<link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />
@endpush

@push('scripts')
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>

<script>
$(document).ready(function() {
    $('select[name="paciente_id"]').select2({
        placeholder: "Buscar paciente...",
        allowClear: true,
        ajax: {
            url: "{{ route('pacientes.buscar') }}",
            dataType: 'json',
            delay: 250,
            data: function(params) {
                return { q: params.term };
            },
            processResults: function(data) {
                return {
                    results: $.map(data, function(item) {
                        return {
                            id: item.id,
                            text: item.nombres + ' ' + item.apellidos
                        }
                    })
                };
            },
            cache: true
        },
        minimumInputLength: 1
    });
});
</script>
@endpush

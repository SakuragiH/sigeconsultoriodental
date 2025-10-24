@extends('layouts.odontologo')

@section('title', 'Nueva Prescripción')
@section('title-section', 'Registrar Prescripción')

@section('content')
<div class="container my-4">
    <form action="{{ route('odontologo.prescripciones.store') }}" method="POST">
        @csrf

        <div class="row">

            <!-- Seleccionar Historial Médico -->
            <div class="col-md-6 mb-3">
                <div class="card shadow-sm card-hover" style="border-left: 5px solid #36808B;">
                    <div class="card-body">
                        <h5 class="card-title field-title">Historial Médico</h5>
                        <select name="historial_id" class="form-control" required>
                            <option value="">Seleccione un historial</option>
                            @foreach($historiales as $historial)
                                <option value="{{ $historial->id }}">
                                    {{ $historial->cita->paciente->nombreCompleto() ?? 'Sin paciente' }} |
                                    {{ $historial->diagnostico ?? 'Sin diagnóstico' }}
                                </option>
                            @endforeach
                        </select>
                        @error('historial_id') <small class="text-danger">{{ $message }}</small> @enderror
                    </div>
                </div>
            </div>

            <!-- Seleccionar Medicamento -->
            <div class="col-md-6 mb-3">
                <div class="card shadow-sm card-hover" style="border-left: 5px solid #5DA6A6;">
                    <div class="card-body">
                        <h5 class="card-title field-title">Medicamento</h5>
                        <select name="medicamento_id" class="form-control" required>
                            <option value="">Seleccione un medicamento</option>
                            @foreach($medicamentos as $medicamento)
                                <option value="{{ $medicamento->id }}">
                                    {{ $medicamento->nombre }} | {{ Str::limit($medicamento->descripcion, 50) }}
                                </option>
                            @endforeach
                        </select>
                        @error('medicamento_id') <small class="text-danger">{{ $message }}</small> @enderror
                    </div>
                </div>
            </div>

            <!-- Dosis -->
            <div class="col-md-6 mb-3">
                <div class="card shadow-sm card-hover" style="border-left: 5px solid #12403B;">
                    <div class="card-body">
                        <h5 class="card-title field-title">Dosis</h5>
                        <input type="text" name="dosis" class="form-control" value="{{ old('dosis') }}" required>
                        @error('dosis') <small class="text-danger">{{ $message }}</small> @enderror
                    </div>
                </div>
            </div>

            <!-- Observaciones -->
            <div class="col-md-6 mb-3">
                <div class="card shadow-sm card-hover" style="border-left: 5px solid #36808B;">
                    <div class="card-body">
                        <h5 class="card-title field-title">Observaciones</h5>
                        <textarea name="observaciones" class="form-control" rows="3">{{ old('observaciones') }}</textarea>
                        @error('observaciones') <small class="text-danger">{{ $message }}</small> @enderror
                    </div>
                </div>
            </div>

        </div>

        <!-- Botones -->
        <div class="d-flex justify-content-start flex-wrap gap-2 mt-3">
            <button type="submit" class="btn" style="background-color:#36808B; color:#ffffff;">
                <i class="fas fa-save"></i> Guardar Prescripción
            </button>
            <a href="{{ route('odontologo.prescripciones.index') }}" class="btn btn-secondary">Cancelar</a>
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

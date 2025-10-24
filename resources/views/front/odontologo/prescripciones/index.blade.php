@extends('layouts.odontologo')

@section('title', 'Prescripciones')

@section('content')
<div class="container mt-4">
    <div class="d-flex justify-content-between align-items-center mb-3">
        <h2 style="color:#12403B;">Prescripciones</h2>
        <a href="{{ route('odontologo.prescripciones.create') }}" 
           class="btn" 
           style="background-color:#36808B; color:#ffffff;">
            <i class="fas fa-plus-circle"></i> Nueva Prescripción
        </a>
    </div>

    @if($prescripciones->isEmpty())
        <div class="alert alert-info text-center">
            No hay prescripciones registradas aún.
        </div>
    @else
        <div class="table-responsive">
            <table class="table table-bordered table-striped align-middle">
                <thead>
                    <tr>
                        <th style="background: linear-gradient(90deg, #36808B, #5DA6A6); color: #fff;">Nro</th>
                        <th style="background: linear-gradient(90deg, #5DA6A6, #12403B); color: #fff;">Paciente</th>
                        <th style="background: linear-gradient(90deg, #12403B, #1A1D22); color: #fff;">Medicamento</th>
                        <th style="background: linear-gradient(90deg, #36808B, #5DA6A6); color: #fff;">Dosis</th>
                        <th style="background: linear-gradient(90deg, #5DA6A6, #12403B); color: #fff;">Observaciones</th>
                        <th style="background: linear-gradient(90deg, #12403B, #1A1D22); color: #fff;">Acciones</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($prescripciones as $prescripcion)
                        <tr>
                            <td>{{ $prescripcion->id }}</td>
                            <td>
    @if($prescripcion->historial?->cita?->paciente)
        <strong>Nombre:</strong> {{ $prescripcion->historial->cita->paciente->nombreCompleto() }} <br>
        <strong>Servicio:</strong> {{ $prescripcion->historial->cita->servicio->nombre ?? 'N/A' }} <br>
        <strong>Fecha:</strong> {{ \Carbon\Carbon::parse($prescripcion->historial->cita->horario->fecha)->format('d/m/Y') }} <br>
        <strong>Hora:</strong> {{ \Carbon\Carbon::parse($prescripcion->historial->cita->horario->hora_inicio)->format('H:i') }} <br>
        <strong>Motivo:</strong> {{ $prescripcion->historial->cita->motivo ?? 'Sin motivo' }}
    @else
        <em>Sin paciente</em>
    @endif
</td>

                            <td>{{ $prescripcion->medicamento->nombre ?? 'N/A' }}</td>
                            <td>{{ $prescripcion->dosis }}</td>
                            <td>{{ Str::limit($prescripcion->observaciones, 50) ?? 'N/A' }}</td>
                            <td>
                                <!-- Botón Ver -->
                                <a href="{{ route('odontologo.prescripciones.show', $prescripcion->id) }}" 
                                   class="btn btn-sm" 
                                   style="background-color:#1A1D22; color:#ffffff;" 
                                   title="Ver">
                                    <i class="fas fa-eye"></i>
                                </a>

                                <!-- Botón Editar -->
                                <a href="{{ route('odontologo.prescripciones.edit', $prescripcion->id) }}" 
                                   class="btn btn-sm" 
                                   style="background-color:#36808B; color:#ffffff;" 
                                   title="Editar">
                                    <i class="fas fa-pen"></i>
                                </a>

                                <!-- Botón Eliminar -->
                                <form action="{{ route('odontologo.prescripciones.destroy', $prescripcion->id) }}" 
                                      method="POST" 
                                      class="d-inline form-eliminar">
                                    @csrf
                                    @method('DELETE')
                                    <button type="button" 
                                            class="btn btn-sm btn-eliminar" 
                                            data-id="{{ $prescripcion->id }}" 
                                            style="background-color:#12403B; color:#ffffff;">
                                        <i class="fas fa-trash-alt"></i>
                                    </button>
                                </form>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    @endif
</div>

<!-- SweetAlert2 -->
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script>
document.addEventListener('DOMContentLoaded', function () {
    const botones = document.querySelectorAll('.btn-eliminar');

    botones.forEach(button => {
        button.addEventListener('click', function() {
            const form = this.closest('form');
            Swal.fire({
                title: '¿Estás seguro?',
                text: "¡No podrás revertir esto!",
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#12403B',
                cancelButtonColor: '#5DA6A6',
                confirmButtonText: 'Sí, eliminar',
                cancelButtonText: 'Cancelar'
            }).then((result) => {
                if (result.isConfirmed) {
                    form.submit();
                }
            });
        });
    });
});
</script>
@endsection

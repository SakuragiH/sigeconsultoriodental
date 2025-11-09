@extends('layouts.odontologo')

@section('title', 'Historiales Médicos')

@section('content')
<div class="container mt-4">
    <div class="d-flex justify-content-between align-items-center mb-3">
        <h2 style="color:#12403B;">Historiales Médicos</h2>
        <a href="{{ route('odontologo.historialesmedicos.create') }}" 
           class="btn" 
           style="background-color:#36808B; color:#ffffff;">
            <i class="fas fa-plus-circle"></i> Nuevo Historial
        </a>
    </div>

    @if($historiales->isEmpty())
        <div class="alert alert-info text-center">
            No hay historiales registrados aún.
        </div>
    @else
        <div class="table-responsive">
            <table class="table table-bordered table-striped align-middle">
                <thead>
                    <tr>
                        <th style="background: linear-gradient(90deg, #36808B, #5DA6A6); color: #fff;">Nro</th>
                        <th style="background: linear-gradient(90deg, #5DA6A6, #12403B); color: #fff;">Cita (Detalles)</th>
                        <th style="background: linear-gradient(90deg, #12403B, #1A1D22); color: #fff;">Diagnóstico</th>
                        <th style="background: linear-gradient(90deg, #36808B, #5DA6A6); color: #fff;">Tratamiento</th>
                        <th style="background: linear-gradient(90deg, #5DA6A6, #12403B); color: #fff;">Archivo</th>
                        <th style="background: linear-gradient(90deg, #12403B, #1A1D22); color: #fff;">Acciones</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($historiales as $historial)
                        <tr>
                            <td>{{ $historial->id }}</td>

                            <!-- Cita (incluye paciente, fecha, hora, servicio y motivo) -->
                            <td>
                                @php
                                    $cita = $historial->cita;
                                @endphp

                                @if($cita)
                                    @php $horario = $cita->horario; @endphp

                                    <strong>Paciente:</strong> 
                                    {{ $cita->paciente->nombreCompleto() ?? ($cita->paciente->nombres ?? 'Sin nombre').' '.($cita->paciente->apellidos ?? '') }} <br>

                                    <strong>Fecha:</strong> {{ $horario ? \Carbon\Carbon::parse($horario->fecha)->format('d/m/Y') : 'N/A' }} <br>
                                    <strong>Hora:</strong> {{ $horario ? \Carbon\Carbon::parse($horario->hora_inicio)->format('H:i') : 'N/A' }} <br>
                                    <strong>Servicio:</strong> {{ $cita->servicio->nombre ?? 'N/A' }} <br>
                                    <strong>Motivo:</strong> {{ $cita->motivo ?? 'Sin motivo' }}
                                @else
                                    <em>Cita eliminada</em>
                                @endif
                            </td>

                            <!-- Diagnóstico -->
                            <td>{{ Str::limit($historial->diagnostico ?? 'N/A', 200) }}</td>

                            <!-- Tratamiento -->
                            <td>{{ Str::limit($historial->tratamiento ?? 'N/A', 200) }}</td>

                            <!-- Archivo -->
                            <td>
                                @if($historial->archivo_path)
                                    <a href="{{ asset('storage/'.$historial->archivo_path) }}" target="_blank">
                                        {{ $historial->archivo_nombre_original ?? 'Archivo' }}
                                    </a>
                                @else
                                    N/A
                                @endif
                            </td>

                            <!-- Acciones -->
                            <td>
                                <a href="{{ route('odontologo.historialesmedicos.show', $historial->id) }}" 
                                   class="btn btn-sm" 
                                   style="background-color:#1A1D22; color:#ffffff;" 
                                   title="Ver">
                                    <i class="fas fa-eye"></i>
                                </a>

                                <a href="{{ route('odontologo.historialesmedicos.edit', $historial->id) }}" 
                                   class="btn btn-sm" 
                                   style="background-color:#36808B; color:#ffffff;" 
                                   title="Editar">
                                    <i class="fas fa-pen"></i>
                                </a>

                                <form action="{{ route('odontologo.historialesmedicos.destroy', $historial->id) }}" 
                                      method="POST" 
                                      class="d-inline form-eliminar">
                                    @csrf
                                    @method('DELETE')
                                    <button type="button" 
                                            class="btn btn-sm btn-eliminar" 
                                            data-id="{{ $historial->id }}" 
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

@extends('layouts.odontologo')

@section('title', 'Citas Odontólogo')

@section('content')
<div class="container">
    <div class="d-flex justify-content-between align-items-center mb-3">
        <h2 style="color:#12403B;">Citas Agendadas</h2>
        <a href="{{ route('odontologo.citas.create') }}" 
           class="btn" 
           style="background-color:#36808B; color:#ffffff;">
            <i class="fas fa-plus"></i> Crear Cita
        </a>
    </div>

    <table class="table table-bordered" style="background-color:#f8f9fa;">
        <thead style="background-color:#5DA6A6; color:#ffffff;">
            <tr>
                <th>Paciente</th>
                <th>Servicio</th>
                <th>Fecha</th>
                <th>Hora</th>
                <th>Estado</th>
                <th>Acciones</th>
            </tr>
        </thead>
        <tbody>
            @foreach($citas as $cita)
            <tr>
                <td>{{ $cita->paciente->nombres }} {{ $cita->paciente->apellidos }}</td>
                <td>{{ $cita->servicio->nombre }}</td>
                <td>{{ $cita->horario->fecha }}</td>
                <td>{{ $cita->horario->hora_inicio }} - {{ $cita->horario->hora_fin }}</td>
                <td>
                    @if($cita->estado == 'Pendiente')
                        <span class="badge" style="background-color:#36808B; color:#ffffff;">Pendiente</span>
                    @elseif($cita->estado == 'Confirmada')
                        <span class="badge" style="background-color:#12403B; color:#ffffff;">Confirmada</span>
                    @else
                        <span class="badge bg-danger">Cancelada</span>
                    @endif
                </td>
                <td>
                    <!-- Ver -->
                    <a href="{{ route('odontologo.citas.show', $cita->id) }}" 
                       class="btn btn-sm" 
                       style="background-color:#1A1D22; color:#ffffff;" 
                       title="Ver">
                        <i class="fas fa-eye"></i>
                    </a>

                    <!-- Editar -->
                    <a href="{{ route('odontologo.citas.edit', $cita->id) }}" 
                       class="btn btn-sm" 
                       style="background-color:#36808B; color:#ffffff;" 
                       title="Editar">
                        <i class="fas fa-pen"></i>
                    </a>

                    <!-- Eliminar -->
                    <form action="{{ route('odontologo.citas.destroy', $cita->id) }}" 
                          method="POST" class="form-delete" style="display:inline;">
                        @csrf
                        @method('DELETE')
                        <button type="submit" 
                                class="btn btn-sm" 
                                style="background-color:#12403B; color:#ffffff;" 
                                title="Eliminar">
                            <i class="fas fa-trash"></i>
                        </button>
                    </form>
                </td>
            </tr>
            @endforeach
        </tbody>
    </table>
</div>
@endsection

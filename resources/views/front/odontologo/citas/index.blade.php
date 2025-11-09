@extends('layouts.odontologo')

@section('title', 'Citas Odontólogo')

@section('content')
<div class="container mt-4">
    <div class="d-flex justify-content-between align-items-center mb-3">
        <h2 style="color:#12403B;">Citas Agendadas</h2>
        <div>
            <a href="{{ route('odontologo.citas.create') }}" 
               class="btn" 
               style="background-color:#36808B; color:#ffffff; margin-right: 8px;">
                <i class="fas fa-plus-circle"></i> Nueva Cita
            </a>
        </div>
    </div>

    @if($citas->isEmpty())
        <div class="alert alert-info text-center">
            No hay citas registradas aún.
        </div>
    @else
        <div class="table-responsive">
            <table class="table table-bordered table-striped align-middle">
                <thead>
                    <tr>
                        <th style="background: linear-gradient(90deg, #36808B, #5DA6A6); color:#fff;">Nro</th>
                        <th style="background: linear-gradient(90deg, #36808B, #5DA6A6); color:#fff;">Paciente</th>
                        <th style="background: linear-gradient(90deg, #5DA6A6, #12403B); color:#fff;">Servicio</th>
                        <th style="background: linear-gradient(90deg, #12403B, #1A1D22); color:#fff;">Fecha</th>
                        <th style="background: linear-gradient(90deg, #36808B, #5DA6A6); color:#fff;">Hora</th>
                        <th style="background: linear-gradient(90deg, #5DA6A6, #12403B); color:#fff;">Estado</th>
                        <th style="background: linear-gradient(90deg, #12403B, #1A1D22); color:#fff;">Acciones</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($citas as $cita)
                    <tr>
                        <td>{{ $loop->iteration }}</td>
                        <td>{{ $cita->paciente->nombres }} {{ $cita->paciente->apellidos }}</td>
                        <td>{{ $cita->servicio->nombre }}</td>
                        <td>{{ \Carbon\Carbon::parse($cita->horario->fecha)->format('d/m/Y') }}</td>
                        <td>{{ $cita->horario->hora_inicio }} - {{ $cita->horario->hora_fin }}</td>
                        <td>
                        @if($cita->estado == 'Pendiente')
                            <span class="badge" style="background-color:#36808B; color:#fff;">Pendiente</span>
                        @elseif($cita->estado == 'Confirmada')
                            <span class="badge" style="background-color:#12403B; color:#fff;">Confirmada</span>
                        @elseif($cita->estado == 'Realizada')
                            <span class="badge" style="background-color:#5DA6A6; color:#fff;">Realizada</span>
                        @elseif($cita->estado == 'Cancelada')
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
                                  method="POST" 
                                  class="d-inline form-eliminar">
                                @csrf
                                @method('DELETE')
                                <button type="button" 
                                        class="btn btn-sm btn-eliminar" 
                                        style="background-color:#12403B; color:#ffffff;" 
                                        data-id="{{ $cita->id }}">
                                    <i class="fas fa-trash"></i>
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

<!-- SweetAlert para confirmación de eliminación -->
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

@push('scripts')
<script>
$(document).ready(function() {
    $('.table').DataTable({
        "pageLength": 5,
        "language": {
            "emptyTable": "No hay información",
            "info": "Mostrando _START_ a _END_ de _TOTAL_ citas",
            "infoEmpty": "Mostrando 0 a 0 de 0 citas",
            "infoFiltered": "(Filtrado de _MAX_ total de citas)",
            "lengthMenu": "<b>Mostrar _MENU_ Citas</b>",
            "loadingRecords": "Cargando...",
            "processing": "Procesando...",
            "search": "Buscador:",
            "zeroRecords": "Sin resultados encontrados",
            "paginate": {
                "first": "Primero",
                "last": "Último",
                "next": "Siguiente",
                "previous": "Anterior"
            }
        }
    });
});
</script>
@endpush

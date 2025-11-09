@extends('layouts.odontologo')

@section('title', 'Horarios de Atención')
@section('title-section', 'Horarios de Atención')

@section('content')
<div class="container my-4">

    <div class="d-flex justify-content-between mb-3">
        <h5 style="color:#12403B;">Horarios existentes</h5>
        <a href="{{ route('odontologo.horarios.create') }}" 
           class="btn" 
           style="background-color:#36808B; color:#ffffff;">
            <i class="fas fa-plus"></i> Agregar Horario
        </a>
    </div>

    <table class="table table-bordered table-striped" style="background-color:#f8f9fa;">
        <thead style="background-color:#5DA6A6; color:#ffffff;">
            <tr>
                <th>Día</th>
                <th>Fecha</th>
                <th>Hora Inicio</th>
                <th>Hora Fin</th>
                <th>Disponible</th>
                <th>Acciones</th>
            </tr>
        </thead>
        <tbody>
            @forelse($horarios as $horario)
            <tr>
                <td>{{ $horario->dia }}</td>
                <td>{{ $horario->fecha }}</td>
                <td>{{ \Carbon\Carbon::parse($horario->hora_inicio)->format('h:i A') }}</td>
                <td>{{ \Carbon\Carbon::parse($horario->hora_fin)->format('h:i A') }}</td>
                <td>
                    @if($horario->disponible)
                        <span class="badge" style="background-color:#36808B; color:#ffffff;">Sí</span>
                    @else
                        <span class="badge" style="background-color:#12403B; color:#ffffff;">No</span>
                    @endif
                </td>
                <td>
                    <a href="{{ route('odontologo.horarios.edit', $horario->id) }}" 
                       class="btn btn-sm" 
                       style="background-color:#36808B; color:#ffffff;" 
                       title="Editar">
                        <i class="fas fa-pen"></i>
                    </a>

                    <form action="{{ route('odontologo.horarios.delete', $horario->id) }}" 
                          method="POST" 
                          class="form-delete" 
                          style="display:inline-block;">
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
            @empty
            <tr>
                <td colspan="6" class="text-center">No hay horarios registrados</td>
            </tr>
            @endforelse
        </tbody>
    </table>
</div>

<!-- SweetAlert2 -->
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

<script>
    document.querySelectorAll('.form-delete').forEach(form => {
        form.addEventListener('submit', function(e){
            e.preventDefault();
            Swal.fire({
                title: '¿Estás seguro?',
                text: "¡No podrás revertir esto!",
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#36808B',
                cancelButtonColor: '#1A1D22',
                confirmButtonText: 'Sí, eliminar',
                cancelButtonText: 'Cancelar'
            }).then((result) => {
                if(result.isConfirmed){
                    form.submit();
                }
            });
        });
    });

    @if(session('success'))
    Swal.fire({
        icon: 'success',
        title: '¡Éxito!',
        text: "{{ session('success') }}",
        confirmButtonColor: '#5DA6A6'
    });
    @endif

    @if(session('error'))
    Swal.fire({
        icon: 'error',
        title: 'Oops...',
        text: "{{ session('error') }}",
        confirmButtonColor: '#36808B'
    });
    @endif
</script>

@push('scripts')
<script>
$(document).ready(function() {
    $('.table').DataTable({
        "pageLength": 5,
        "language": {
            "emptyTable": "No hay información",
            "info": "Mostrando _START_ a _END_ de _TOTAL_ horarios",
            "infoEmpty": "Mostrando 0 a 0 de 0 horarios",
            "infoFiltered": "(Filtrado de _MAX_ total horarios)",
            "lengthMenu": "<b>Mostrar _MENU_ horarios</b>",
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
@endsection

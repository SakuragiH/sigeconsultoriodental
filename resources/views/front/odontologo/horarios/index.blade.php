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
                <td>{{ $horario->hora_inicio }}</td>
                <td>{{ $horario->hora_fin }}</td>
                <td>
                    @if($horario->disponible)
                        <span class="badge" style="background-color:#36808B; color:#ffffff;">Sí</span>
                    @else
                        <span class="badge" style="background-color:#12403B; color:#ffffff;">No</span>
                    @endif
                </td>
                <td>
                    <!-- Editar -->
                    <a href="{{ route('odontologo.horarios.edit', $horario->id) }}" 
                       class="btn btn-sm" 
                       style="background-color:#36808B; color:#ffffff;" 
                       title="Editar">
                        <i class="fas fa-pen"></i>
                    </a>

                    <!-- Eliminar -->
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
    // Confirmación de eliminar
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

    // Alertas de éxito
    @if(session('success'))
    Swal.fire({
        icon: 'success',
        title: '¡Éxito!',
        text: "{{ session('success') }}",
        confirmButtonColor: '#5DA6A6'
    });
    @endif

    // Alertas de error
    @if(session('error'))
    Swal.fire({
        icon: 'error',
        title: 'Oops...',
        text: "{{ session('error') }}",
        confirmButtonColor: '#36808B'
    });
    @endif
</script>
@endsection

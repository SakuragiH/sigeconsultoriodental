@extends('layouts.odontologo')

@section('title', 'Medicamentos')

@section('content')
<div class="container mt-4">
    <div class="d-flex justify-content-between align-items-center mb-3">
        <h2 style="color:#12403B;">Medicamentos</h2>
        <a href="{{ route('odontologo.medicamentos.create') }}" 
           class="btn" 
           style="background-color:#36808B; color:#ffffff;">
            <i class="fas fa-plus-circle"></i> Nuevo Medicamento
        </a>
    </div>

    @if($medicamentos->isEmpty())
        <div class="alert alert-info text-center">
            No hay medicamentos registrados aún.
        </div>
    @else
        <div class="table-responsive">
            <table class="table table-bordered table-striped align-middle">
                <thead>
                    <tr>
                        <th style="background: linear-gradient(90deg, #36808B, #5DA6A6); color: #fff;">Nro</th>
                        <th style="background: linear-gradient(90deg, #5DA6A6, #12403B); color: #fff;">Nombre</th>
                        <th style="background: linear-gradient(90deg, #12403B, #1A1D22); color: #fff;">Descripción</th>
                        <th style="background: linear-gradient(90deg, #36808B, #5DA6A6); color: #fff;">Dosis</th>
                        <th style="background: linear-gradient(90deg, #5DA6A6, #12403B); color: #fff;">Frecuencia</th>
                        <th style="background: linear-gradient(90deg, #12403B, #1A1D22); color: #fff;">Vía de Administración</th>
                        <th style="background: linear-gradient(90deg, #36808B, #5DA6A6); color: #fff;">Acciones</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($medicamentos as $medicamento)
                        <tr>
                            <td>{{ $medicamento->id }}</td>
                            <td>{{ $medicamento->nombre }}</td>
                            <td>{{ Str::limit($medicamento->descripcion, 50) }}</td>
                            <td>{{ $medicamento->dosis }}</td>
                            <td>{{ $medicamento->frecuencia }}</td>
                            <td>{{ $medicamento->via_administracion }}</td>
                            <td>
                                <!-- Botón Ver -->
                                <a href="{{ route('odontologo.medicamentos.show', $medicamento->id) }}" 
                                   class="btn btn-sm" 
                                   style="background-color:#1A1D22; color:#ffffff;" 
                                   title="Ver">
                                    <i class="fas fa-eye"></i>
                                </a>

                                <!-- Botón Editar -->
                                <a href="{{ route('odontologo.medicamentos.edit', $medicamento->id) }}" 
                                   class="btn btn-sm" 
                                   style="background-color:#36808B; color:#ffffff;" 
                                   title="Editar">
                                    <i class="fas fa-pen"></i>
                                </a>

                                <!-- Botón Eliminar -->
                                <form action="{{ route('odontologo.medicamentos.destroy', $medicamento->id) }}" 
                                      method="POST" 
                                      class="d-inline form-eliminar">
                                    @csrf
                                    @method('DELETE')
                                    <button type="button" 
                                            class="btn btn-sm btn-eliminar" 
                                            data-id="{{ $medicamento->id }}" 
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

@extends('layouts.odontologo')

@section('title', 'Servicios Odontólogo')

@section('content')
<div class="container mt-4">
    <div class="d-flex justify-content-between align-items-center mb-3">
        <h2 style="color:#12403B;">Servicios Disponibles</h2>
        <a href="{{ route('odontologo.servicios.create') }}" 
           class="btn" 
           style="background-color:#36808B; color:#ffffff;">
            <i class="fas fa-plus-circle"></i> Nuevo Servicio
        </a>
    </div>

    @if($servicios->isEmpty())
        <div class="alert alert-info text-center">
            No hay servicios registrados aún.
        </div>
    @else
        <div class="table-responsive">
            <table class="table table-bordered table-striped align-middle">
                <thead>
                    <tr>
                        <th style="background: linear-gradient(90deg, #36808B, #5DA6A6); color: #fff;">Nro</th>
                        <th style="background: linear-gradient(90deg, #5DA6A6, #12403B); color: #fff;">Nombre</th>
                        <th style="background: linear-gradient(90deg, #12403B, #1A1D22); color: #fff;">Precio</th>
                        <th style="background: linear-gradient(90deg, #36808B, #5DA6A6); color: #fff;">Descripción</th>
                        <th style="background: linear-gradient(90deg, #5DA6A6, #12403B); color: #fff;">Foto</th>
                        <th style="background: linear-gradient(90deg, #12403B, #1A1D22); color: #fff;">Acciones</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($servicios as $index => $servicio)
                        <tr>
                            <td>{{ $index + 1 }}</td>
                            <td>{{ $servicio->nombre }}</td>
                            <td>${{ number_format($servicio->precio, 2) }}</td>
                            <td>{{ $servicio->descripcion }}</td>
                            <td>
                                <img 
                                    src="{{ $servicio->foto ? (str_starts_with($servicio->foto,'storage') ? url($servicio->foto) : url('storage/'.$servicio->foto)) : url('storage/servicios/default.png') }}" 
                                    alt="{{ $servicio->nombre }}" 
                                    width="60" height="60" 
                                    style="object-fit:cover; border-radius:10px;">
                            </td>
                            <td>
                                <a href="{{ route('odontologo.servicios.show', $servicio->id) }}" 
                                   class="btn btn-sm" 
                                   style="background-color:#1A1D22; color:#ffffff;" 
                                   title="Ver">
                                    <i class="fas fa-eye"></i>
                                </a>

                                <a href="{{ route('odontologo.servicios.edit', $servicio->id) }}" 
                                   class="btn btn-sm" 
                                   style="background-color:#36808B; color:#ffffff;" 
                                   title="Editar">
                                    <i class="fas fa-pen"></i>
                                </a>

                                <form action="{{ route('odontologo.servicios.destroy', $servicio->id) }}" 
                                      method="POST" 
                                      class="d-inline form-eliminar">
                                    @csrf
                                    @method('DELETE')
                                    <button type="button" 
                                            class="btn btn-sm btn-eliminar" 
                                            data-id="{{ $servicio->id }}" 
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

@push('scripts')
<script>
$(document).ready(function() {
    $('.table').DataTable({
        "pageLength": 5,
        "language": {
            "emptyTable": "No hay información",
            "info": "Mostrando _START_ a _END_ de _TOTAL_ servicios",
            "infoEmpty": "Mostrando 0 a 0 de 0 servicios",
            "infoFiltered": "(Filtrado de _MAX_ total servicios)",
            "lengthMenu": "<b>Mostrar _MENU_ Servicios</b>",
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

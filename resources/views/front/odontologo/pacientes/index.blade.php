@extends('layouts.odontologo')

@section('title', 'Pacientes')

@section('content')
<div class="container mt-4">
    <div class="d-flex justify-content-between align-items-center mb-3">
        <h2 style="color:#12403B;">Pacientes</h2>
        <a href="{{ route('odontologo.pacientes.create') }}" 
           class="btn" 
           style="background-color:#36808B; color:#ffffff;">
            <i class="fas fa-plus-circle"></i> Nuevo Paciente
        </a>
    </div>
    

    @if($pacientes->isEmpty())
        <div class="alert alert-info text-center">
            No hay pacientes registrados aún.
        </div>
    @else
        <div class="table-responsive">
            <table class="table table-bordered table-striped align-middle">
                <thead>
                    <tr>
                        <th style="background: linear-gradient(90deg, #36808B, #5DA6A6); color: #fff;">Nro</th>
                        <th style="background: linear-gradient(90deg, #5DA6A6, #12403B); color: #fff;">Foto</th>
                        <th style="background: linear-gradient(90deg, #12403B, #1A1D22); color: #fff;">Nombre</th>
                        <th style="background: linear-gradient(90deg, #36808B, #5DA6A6); color: #fff;">CI</th>
                        <th style="background: linear-gradient(90deg, #5DA6A6, #12403B); color: #fff;">Teléfono</th>
                        <th style="background: linear-gradient(90deg, #12403B, #1A1D22); color: #fff;">Fecha de Nacimiento</th>
                        <th style="background: linear-gradient(90deg, #36808B, #5DA6A6); color: #fff;">Género</th>
                        <th style="background: linear-gradient(90deg, #36808B, #5DA6A6); color: #fff;">Acciones</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($pacientes as $paciente)
                        <tr>
                            <td>{{ $paciente->id }}</td>
                            <td>
                                @if($paciente->foto && file_exists(storage_path('app/public/pacientes/' . $paciente->foto)))
                                    <img src="{{ asset('storage/pacientes/' . $paciente->foto) }}" 
                                         alt="Foto de {{ $paciente->nombres }}" 
                                         style="width:50px; height:50px; object-fit:cover; border-radius:50%;">
                                @else
                                    <img src="{{ asset('storage/pacientes/usuariopordefecto.png') }}" 
                                         alt="Foto por defecto" 
                                         style="width:50px; height:50px; object-fit:cover; border-radius:50%;">
                                @endif
                            </td>
                            <td>{{ $paciente->nombres }} {{ $paciente->apellidos }}</td>
                            <td>{{ $paciente->ci }}</td>
                            <td>{{ $paciente->telefono }}</td>
                            <td>{{ \Carbon\Carbon::parse($paciente->fecha_nacimiento)->format('d/m/Y') }}</td>
                            <td>{{ $paciente->genero }}</td>
                            <td>
                                <a href="{{ route('odontologo.pacientes.show', $paciente->id) }}" 
                                   class="btn btn-sm" 
                                   style="background-color:#1A1D22; color:#ffffff;" 
                                   title="Ver">
                                    <i class="fas fa-eye"></i>
                                </a>

                                <a href="{{ route('odontologo.pacientes.edit', $paciente->id) }}" 
                                   class="btn btn-sm" 
                                   style="background-color:#36808B; color:#ffffff;" 
                                   title="Editar">
                                    <i class="fas fa-pen"></i>
                                </a>

                                <form action="{{ route('odontologo.pacientes.destroy', $paciente->id) }}" 
                                    method="POST" 
                                    class="d-inline form-eliminar">
                                    @csrf
                                    @method('DELETE')
                                    <button type="button" 
                                            class="btn btn-sm btn-eliminar" 
                                            data-id="{{ $paciente->id }}" 
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
    document.querySelectorAll('.btn-eliminar').forEach(btn => {
        btn.addEventListener('click', function() {
            const form = this.closest('form');
            Swal.fire({
                title: '¿Estás seguro?',
                text: "¡No podrás revertir esto!",
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#3085d6',
                cancelButtonColor: '#d33',
                confirmButtonText: 'Sí, eliminar',
                cancelButtonText: 'Cancelar'
            }).then((result) => {
                if (result.isConfirmed) {
                    form.submit(); // aquí se envía el DELETE
                }
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
            "info": "Mostrando _START_ a _END_ de _TOTAL_ pacientes",
            "infoEmpty": "Mostrando 0 a 0 de 0 pacientes",
            "infoFiltered": "(Filtrado de _MAX_ total pacientes)",
            "lengthMenu": "<b>Mostrar _MENU_ Pacientes</b>",
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


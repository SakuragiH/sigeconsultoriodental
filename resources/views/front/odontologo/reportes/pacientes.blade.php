@extends('layouts.odontologo')

@section('title', 'Pacientes')

@push('styles')
<style>
/* Degradados y colores para los encabezados */
th.nro    { background: linear-gradient(90deg, #36808B, #5DA6A6); color: #fff; }
th.foto   { background: linear-gradient(90deg, #5DA6A6, #12403B); color: #fff; }
th.nombre { background: linear-gradient(90deg, #12403B, #1A1D22); color: #fff; }
th.ci     { background: linear-gradient(90deg, #36808B, #5DA6A6); color: #fff; }
th.telefono { background: linear-gradient(90deg, #5DA6A6, #12403B); color: #fff; }
th.fecha  { background: linear-gradient(90deg, #12403B, #1A1D22); color: #fff; }
th.genero { background: linear-gradient(90deg, #36808B, #5DA6A6); color: #fff; }

/* Tabla */
.table td, .table th {
    vertical-align: middle;
    text-align: center;
}

.img-circle {
    width: 50px;
    height: 50px;
    object-fit: cover;
    border-radius: 50%;
}
</style>
@endpush

@section('content')
<div class="container mt-4">
    <div class="d-flex justify-content-between align-items-center mb-3">
        <h2 style="color:#12403B;">Reporte de Pacientes</h2>
        <a id="exportPdfBtn" href="{{ route('odontologo.reportes.pacientes.pdf') }}" 
           class="btn" style="background-color:#36808B; color:#fff;" target="_blank">
            <i class="fas fa-file-pdf"></i> Exportar PDF
        </a>
    </div>


    @if($pacientes->isEmpty())
        <div class="alert alert-info text-center">No hay pacientes registrados.</div>
    @else
        <div class="table-responsive">
            <table class="table table-bordered table-striped align-middle" id="pacientesTable">
                <thead>
                    <tr>
                        <th class="nro">Nro</th>
                        <th class="foto">Foto</th>
                        <th class="nombre">Nombre Completo</th>
                        <th class="ci">CI</th>
                        <th class="telefono">Teléfono</th>
                        <th class="fecha">Fecha Nacimiento</th>
                        <th class="genero">Género</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($pacientes as $paciente)
                        <tr>
                            <td>{{ $paciente->id }}</td>
                            <td>
                                @if($paciente->foto && file_exists(storage_path('app/public/pacientes/' . $paciente->foto)))
                                    <img src="{{ asset('storage/pacientes/' . $paciente->foto) }}" alt="Foto" class="img-circle">
                                @else
                                    <img src="{{ asset('storage/pacientes/usuariopordefecto.png') }}" alt="Foto por defecto" class="img-circle">
                                @endif
                            </td>
                            <td>{{ $paciente->nombres }} {{ $paciente->apellidos }}</td>
                            <td>{{ $paciente->ci }}</td>
                            <td>{{ $paciente->telefono }}</td>
                            <td>{{ \Carbon\Carbon::parse($paciente->fecha_nacimiento)->format('d/m/Y') }}</td>
                            <td>{{ $paciente->genero }}</td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    @endif
</div>
@endsection

@push('scripts')
<script>
$(document).ready(function() {
    $('#pacientesTable').DataTable({
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

@extends('layouts.odontologo')

@section('title', 'Citas')

@push('styles')
<style>
/* Degradados y colores para los encabezados */
th.nro     { background: linear-gradient(90deg, #36808B, #5DA6A6); color: #fff; }
th.paciente { background: linear-gradient(90deg, #5DA6A6, #12403B); color: #fff; }
th.servicio { background: linear-gradient(90deg, #12403B, #1A1D22); color: #fff; }
th.fecha    { background: linear-gradient(90deg, #36808B, #5DA6A6); color: #fff; }
th.horario  { background: linear-gradient(90deg, #5DA6A6, #12403B); color: #fff; }
th.estado   { background: linear-gradient(90deg, #12403B, #1A1D22); color: #fff; }

/* Tabla */
.table td, .table th {
    vertical-align: middle;
    text-align: center;
}
</style>
@endpush

@section('content')
<div class="container mt-4">
    <div class="d-flex justify-content-between align-items-center mb-3">
        <h2 style="color:#12403B;">Reporte de Citas</h2>
        <a id="exportPdfBtn" href="{{ route('odontologo.reportes.citas.pdf') }}" 
           class="btn" style="background-color:#36808B; color:#fff;" target="_blank">
            <i class="fas fa-file-pdf"></i> Exportar PDF
        </a>
    </div>

    @if($citas->isEmpty())
        <div class="alert alert-info text-center">No hay citas registradas.</div>
    @else
        <div class="table-responsive">
            <table class="table table-bordered table-striped align-middle" id="citasTable">
                <thead>
                    <tr>
                        <th class="nro">Nro</th>
                        <th class="paciente">Paciente</th>
                        <th class="servicio">Servicio</th>
                        <th class="fecha">Fecha</th>
                        <th class="horario">Horario</th>
                        <th class="estado">Estado</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($citas as $cita)
                        <tr>
                            <td>{{ $loop->iteration }}</td>
                            <td>{{ $cita->paciente->nombres ?? '-' }} {{ $cita->paciente->apellidos ?? '' }}</td>
                            <td>{{ $cita->servicio->nombre ?? '-' }}</td>
                            <td>{{ \Carbon\Carbon::parse($cita->fecha)->format('d/m/Y') }}</td>
                            <td>{{ $cita->horario->hora_inicio ?? '-' }} - {{ $cita->horario->hora_fin ?? '-' }}</td>
                            <td>{{ $cita->estado ?? '-' }}</td>
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
    $('#citasTable').DataTable({
        "pageLength": 5,
        "language": {
            "emptyTable": "No hay información",
            "info": "Mostrando _START_ a _END_ de _TOTAL_ citas",
            "infoEmpty": "Mostrando 0 a 0 de 0 citas",
            "infoFiltered": "(Filtrado de _MAX_ total citas)",
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

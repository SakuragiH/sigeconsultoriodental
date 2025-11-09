@extends('layouts.odontologo')

@section('title', 'Historial Médico')

@push('styles')
<style>
/* Degradados para encabezados */
th.nro           { background: linear-gradient(90deg, #36808B, #5DA6A6); color: #fff; }
th.paciente      { background: linear-gradient(90deg, #5DA6A6, #12403B); color: #fff; }
th.diagnostico   { background: linear-gradient(90deg, #12403B, #1A1D22); color: #fff; }
th.tratamiento   { background: linear-gradient(90deg, #36808B, #5DA6A6); color: #fff; }
th.observaciones { background: linear-gradient(90deg, #12403B, #1A1D22); color: #fff; }

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
        <h2 style="color:#12403B;">Reporte de Historial Médico</h2>
        <a id="exportPdfBtn" href="{{ route('odontologo.reportes.historialesmedicos.pdf') }}" 
           class="btn" style="background-color:#36808B; color:#fff;" target="_blank">
           <i class="fas fa-file-pdf"></i> Exportar PDF
        </a>
    </div>

    @if($historiales->isEmpty())
        <div class="alert alert-info text-center">No hay registros de historial médico.</div>
    @else
        <div class="table-responsive">
            <table class="table table-bordered table-striped align-middle" id="historialesTable">
                <thead>
                    <tr>
                        <th class="nro">Nro</th>
                        <th class="paciente">Paciente</th>
                        <th class="diagnostico">Diagnóstico</th>
                        <th class="tratamiento">Tratamiento</th>
                        <th class="observaciones">Observaciones</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($historiales as $h)
                        <tr>
                            <td>{{ $loop->iteration }}</td>
                            <td>{{ $h->paciente->nombres }} {{ $h->paciente->apellidos }}</td>
                            <td>{{ $h->diagnostico }}</td>
                            <td>{{ $h->tratamiento ?? '-' }}</td>
                            <td>{{ $h->observaciones_paciente ?? '-' }}</td>
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
    var table = $('#historialesTable').DataTable({
        "pageLength": 5,
        "language": {
            "emptyTable": "No hay información",
            "info": "Mostrando _START_ a _END_ de _TOTAL_ registros",
            "infoEmpty": "Mostrando 0 a 0 de 0 registros",
            "infoFiltered": "(Filtrado de _MAX_ total registros)",
            "lengthMenu": "<b>Mostrar _MENU_ registros</b>",
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

    // PDF dinámico según el buscador de DataTables
    $('#exportPdfBtn').on('click', function(e) {
        e.preventDefault();
        let url = $(this).attr('href');
        let search = $('#historialesTable_filter input').val();
        if(search) {
            url += (url.includes('?') ? '&' : '?') + 'q=' + encodeURIComponent(search);
        }
        window.open(url, '_blank');
    });
});
</script>
@endpush

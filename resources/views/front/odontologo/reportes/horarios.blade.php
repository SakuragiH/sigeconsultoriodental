@extends('layouts.odontologo')

@section('title', 'Horarios')

@push('styles')
<style>
/* Degradados para encabezados */
th.nro     { background: linear-gradient(90deg, #36808B, #5DA6A6); color: #fff; }
th.dia     { background: linear-gradient(90deg, #5DA6A6, #12403B); color: #fff; }
th.fecha   { background: linear-gradient(90deg, #12403B, #1A1D22); color: #fff; }
th.horario { background: linear-gradient(90deg, #36808B, #5DA6A6); color: #fff; }
th.estado  { background: linear-gradient(90deg, #12403B, #1A1D22); color: #fff; }

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
        <h2 style="color:#12403B;">Reporte de Horarios</h2>
        <a id="exportPdfBtn" href="{{ route('odontologo.reportes.horarios.pdf') }}" 
           class="btn" style="background-color:#36808B; color:#fff;" target="_blank">
           <i class="fas fa-file-pdf"></i> Exportar PDF
        </a>
    </div>

    @if($horarios->isEmpty())
        <div class="alert alert-info text-center">No hay horarios registrados.</div>
    @else
        <div class="table-responsive">
            <table class="table table-bordered table-striped align-middle" id="horariosTable">
                <thead>
                    <tr>
                        <th class="nro">Nro</th>
                        <th class="dia">Día</th>
                        <th class="fecha">Fecha</th>
                        <th class="horario">Horario</th>
                        <th class="estado">Estado</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($horarios as $horario)
                        <tr>
                            <td>{{ $loop->iteration }}</td>
                            <td>{{ $horario->dia }}</td>
                            <td>{{ \Carbon\Carbon::parse($horario->fecha)->format('d/m/Y') }}</td>
                            <td>{{ \Carbon\Carbon::parse($horario->hora_inicio)->format('H:i') }} - {{ \Carbon\Carbon::parse($horario->hora_fin)->format('H:i') }}</td>
                            <td>{{ $horario->disponible ? 'Disponible' : 'Bloqueado' }}</td>
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
    var table = $('#horariosTable').DataTable({
        "pageLength": 5,
        "language": {
            "emptyTable": "No hay información",
            "info": "Mostrando _START_ a _END_ de _TOTAL_ horarios",
            "infoEmpty": "Mostrando 0 a 0 de 0 horarios",
            "infoFiltered": "(Filtrado de _MAX_ total horarios)",
            "lengthMenu": "<b>Mostrar _MENU_ Horarios</b>",
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
        let search = $('#horariosTable_filter input').val(); // Tomamos el texto del buscador
        if(search) {
            url += (url.includes('?') ? '&' : '?') + 'q=' + encodeURIComponent(search);
        }
        window.open(url, '_blank');
    });
});
</script> 
@endpush

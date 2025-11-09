@extends('layouts.odontologo')

@section('title', 'Medicamentos')

@push('styles')
<style>
/* Degradados para encabezados */
th.nro     { background: linear-gradient(90deg, #36808B, #5DA6A6); color: #fff; }
th.nombre  { background: linear-gradient(90deg, #5DA6A6, #12403B); color: #fff; }
th.descripcion { background: linear-gradient(90deg, #12403B, #1A1D22); color: #fff; }
th.dosis  { background: linear-gradient(90deg, #36808B, #5DA6A6); color: #fff; }
th.frecuencia { background: linear-gradient(90deg, #12403B, #1A1D22); color: #fff; }
th.via    { background: linear-gradient(90deg, #5DA6A6, #12403B); color: #fff; }

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
        <h2 style="color:#12403B;">Reporte de Medicamentos</h2>
        <a id="exportPdfBtn" href="{{ route('odontologo.reportes.medicamentos.pdf') }}" 
           class="btn" style="background-color:#36808B; color:#fff;" target="_blank">
           <i class="fas fa-file-pdf"></i> Exportar PDF
        </a>
    </div>

    @if($medicamentos->isEmpty())
        <div class="alert alert-info text-center">No hay medicamentos registrados.</div>
    @else
        <div class="table-responsive">
            <table class="table table-bordered table-striped align-middle" id="medicamentosTable">
                <thead>
                    <tr>
                        <th class="nro">Nro</th>
                        <th class="nombre">Nombre</th>
                        <th class="descripcion">Descripción</th>
                        <th class="dosis">Dosis</th>
                        <th class="frecuencia">Frecuencia</th>
                        <th class="via">Vía de administración</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($medicamentos as $m)
                        <tr>
                            <td>{{ $loop->iteration }}</td>
                            <td>{{ $m->nombre }}</td>
                            <td>{{ $m->descripcion ?? '-' }}</td>
                            <td>{{ $m->dosis ?? '-' }}</td>
                            <td>{{ $m->frecuencia ?? '-' }}</td>
                            <td>{{ $m->via_administracion ?? '-' }}</td>
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
    var table = $('#medicamentosTable').DataTable({
        "pageLength": 5,
        "language": {
            "emptyTable": "No hay información",
            "info": "Mostrando _START_ a _END_ de _TOTAL_ medicamentos",
            "infoEmpty": "Mostrando 0 a 0 de 0 medicamentos",
            "infoFiltered": "(Filtrado de _MAX_ total medicamentos)",
            "lengthMenu": "<b>Mostrar _MENU_ Medicamentos</b>",
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
        let search = $('#medicamentosTable_filter input').val(); // Tomamos el texto del buscador
        if(search) {
            url += (url.includes('?') ? '&' : '?') + 'q=' + encodeURIComponent(search);
        }
        window.open(url, '_blank');
    });
});
</script>
@endpush

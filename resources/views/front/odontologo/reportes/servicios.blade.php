@extends('layouts.odontologo')

@section('title', 'Servicios')

@push('styles')
<style>
/* Degradados para encabezados */
th.nro     { background: linear-gradient(90deg, #36808B, #5DA6A6); color: #fff; }
th.nombre  { background: linear-gradient(90deg, #5DA6A6, #12403B); color: #fff; }
th.precio  { background: linear-gradient(90deg, #12403B, #1A1D22); color: #fff; }
th.descripcion { background: linear-gradient(90deg, #36808B, #5DA6A6); color: #fff; }

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
        <h2 style="color:#12403B;">Reporte de Servicios</h2>
        <a id="exportPdfBtn" href="{{ route('odontologo.reportes.servicios.pdf') }}" 
           class="btn" style="background-color:#36808B; color:#fff;" target="_blank">
           <i class="fas fa-file-pdf"></i> Exportar PDF
        </a>
    </div>

    @if($servicios->isEmpty())
        <div class="alert alert-info text-center">No hay servicios registrados.</div>
    @else
        <div class="table-responsive">
            <table class="table table-bordered table-striped align-middle" id="serviciosTable">
                <thead>
                    <tr>
                        <th class="nro">Nro</th>
                        <th class="nombre">Nombre</th>
                        <th class="precio">Precio</th>
                        <th class="descripcion">Descripción</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($servicios as $servicio)
                        <tr>
                            <td>{{ $loop->iteration }}</td>
                            <td>{{ $servicio->nombre }}</td>
                            <td>{{ $servicio->precio ? '$' . number_format($servicio->precio, 2) : '-' }}</td>
                            <td>{{ $servicio->descripcion ?? '-' }}</td>
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
    var table = $('#serviciosTable').DataTable({
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

    // PDF dinámico según el buscador de DataTables
    $('#exportPdfBtn').on('click', function(e) {
        e.preventDefault();
        let url = $(this).attr('href');
        let search = $('#serviciosTable_filter input').val(); // Tomamos el texto del buscador
        if(search) {
            url += (url.includes('?') ? '&' : '?') + 'q=' + encodeURIComponent(search);
        }
        window.open(url, '_blank');
    });
});
</script> 
@endpush

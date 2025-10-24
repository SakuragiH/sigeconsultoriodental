@extends('adminlte::page')

@section('title', 'Medicamentos')

@section('content_header')
    <h1><b>Listado de Medicamentos</b></h1>
    <hr>
@stop

@section('content')
    <div class="row">
        <div class="col-md-10">
            <div class="card card-outline card-primary">
                <div class="card-header">
                    <h3 class="card-title">Medicamentos registrados</h3>
                    <div class="card-tools">
                        <a href="{{ route('admin.medicamentos.create') }}" class="btn btn-primary">Crear nuevo</a>
                    </div>
                </div>
                <div class="card-body">
                    <table id="medicamentosTable" class="table table-bordered table-hover table-striped table-sm">
                        <thead>
                        <tr>
                            <th style="text-align: center">#</th>
                            <th>Nombre</th>
                            <th>Descripción</th>
                            <th>Dosis</th>
                            <th>Frecuencia</th>
                            <th>Vía Administración</th>
                            <th style="text-align: center">Acciones</th>
                        </tr>
                        </thead>
                        <tbody>
                        @php $contador = 1; @endphp
                        @foreach($medicamentos as $medicamento)
                            <tr>
                                <td style="text-align: center">{{ $contador++ }}</td>
                                <td>{{ $medicamento->nombre }}</td>
                                <td>{{ $medicamento->descripcion }}</td>
                                <td>{{ $medicamento->dosis }}</td>
                                <td>{{ $medicamento->frecuencia }}</td>
                                <td>{{ $medicamento->via_administracion }}</td>
                                <td style="text-align: center">
                                    <div class="btn-group" role="group">
                                        <a href="{{ route('admin.medicamentos.edit', $medicamento->id) }}" class="btn btn-success btn-sm">
                                            <i class="fas fa-pencil-alt"></i>
                                        </a>
                                        <form action="{{ route('admin.medicamentos.destroy', $medicamento->id) }}" method="POST"
                                              id="formDelete{{ $medicamento->id }}" onsubmit="return confirmDelete{{ $medicamento->id }}(event)">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="btn btn-danger btn-sm">
                                                <i class="fas fa-trash"></i>
                                            </button>
                                        </form>
                                        <script>
                                            function confirmDelete{{ $medicamento->id }}(event) {
                                                event.preventDefault();
                                                Swal.fire({
                                                    title: '¿Desea eliminar este medicamento?',
                                                    icon: 'question',
                                                    showDenyButton: true,
                                                    confirmButtonText: 'Eliminar',
                                                    confirmButtonColor: '#a5161d',
                                                    denyButtonText: 'Cancelar',
                                                    denyButtonColor: '#270a0a',
                                                }).then((result) => {
                                                    if(result.isConfirmed){
                                                        document.getElementById('formDelete{{ $medicamento->id }}').submit();
                                                    }
                                                });
                                            }
                                        </script>
                                    </div>
                                </td>
                            </tr>
                        @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
@stop

@section('css')
    <style>
        #medicamentosTable_wrapper .dt-buttons {
            background-color: transparent;
            box-shadow: none;
            border: none;
            display: flex;
            justify-content: center;
            gap: 10px;
            margin-bottom: 15px;
        }
        #medicamentosTable_wrapper .btn { color: #fff; border-radius: 4px; padding: 5px 15px; font-size: 14px; }
        .btn-danger { background-color: #dc3545; border: none; }
        .btn-success { background-color: #28a745; border: none; }
        .btn-info { background-color: #17a2b8; border: none; }
        .btn-warning { background-color: #ffc107; color: #212529; border: none; }
        .btn-default { background-color: #6e7176; color: #212529; border: none; }
    </style>
@stop

@section('js')
    <script>
        $(function () {
            $("#medicamentosTable").DataTable({
                "pageLength": 5,
                "language": {
                    "emptyTable": "No hay información",
                    "info": "Mostrando _START_ a _END_ de _TOTAL_ medicamentos",
                    "infoEmpty": "Mostrando 0 a 0 de 0 medicamentos",
                    "infoFiltered": "(Filtrado de _MAX_ total medicamentos)",
                    "lengthMenu": "Mostrar _MENU_ medicamentos",
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
                },
                "responsive": true,
                "lengthChange": true,
                "autoWidth": false,
                buttons: [
                    { text: '<i class="fas fa-copy"></i> COPIAR', extend: 'copy', className: 'btn btn-default' },
                    { text: '<i class="fas fa-file-pdf"></i> PDF', extend: 'pdf', className: 'btn btn-danger' },
                    { text: '<i class="fas fa-file-csv"></i> CSV', extend: 'csv', className: 'btn btn-info' },
                    { text: '<i class="fas fa-file-excel"></i> EXCEL', extend: 'excel', className: 'btn btn-success' },
                    { text: '<i class="fas fa-print"></i> IMPRIMIR', extend: 'print', className: 'btn btn-warning' }
                ]
            }).buttons().container().appendTo('#medicamentosTable_wrapper .row:eq(0)');
        });
    </script>
@stop

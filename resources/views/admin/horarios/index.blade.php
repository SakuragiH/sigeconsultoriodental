@extends('adminlte::page')

@section('title', 'Horarios')

@section('content_header')
    <h1><b>Listado de Horarios</b></h1>
    <hr>
@stop

@section('content')
<div class="row">
    <div class="col-md-12">
        <div class="card card-outline card-primary">
            <div class="card-header">
                <h3 class="card-title">Horarios registrados</h3>
                <div class="card-tools">
                    <a href="{{ route('admin.horarios.create') }}" class="btn btn-primary">Crear nuevo</a>
                </div>
            </div>
            <div class="card-body">
                <table id="horariosTable" class="table table-bordered table-hover table-striped table-sm" style="width:100%">
                    <thead>
                        <tr>
                            <th style="text-align: center">Nro</th>
                            <th>Odontólogo</th>
                            <th>Fecha</th> <!-- Nueva columna -->
                            <th>Día</th>
                            <th>Hora Inicio</th>
                            <th>Hora Fin</th>
                            <th>Disponible</th>
                            <th style="text-align: center">Acciones</th>
                        </tr>
                    </thead>
                    <tbody>
                        @php $contador = 1; @endphp
                        @foreach($horarios as $horario)
                        <tr>
                            <td style="text-align: center">{{ $contador++ }}</td>
                            <td>{{ $horario->odontologo->nombres }} {{ $horario->odontologo->apellidos }}</td>
                            <td>{{ \Carbon\Carbon::parse($horario->fecha)->format('d/m/Y') }}</td>
                            <td>{{ $horario->dia }}</td>
                            <td>{{ \Carbon\Carbon::parse($horario->hora_inicio)->format('h:i A') }}</td>
                            <td>{{ \Carbon\Carbon::parse($horario->hora_fin)->format('h:i A') }}</td>
                            <td style="text-align: center">
                                @if($horario->disponible)
                                    <span class="badge badge-success">Sí</span>
                                @else
                                    <span class="badge badge-danger">No</span>
                                @endif
                            </td>
                            <td style="text-align: center">
                                <div class="btn-group d-flex justify-content-center" role="group">
                                    <a href="{{ route('admin.horarios.show', $horario->id) }}" class="btn btn-info btn-sm accion-btn">
                                        <i class="fas fa-eye"></i>
                                    </a>
                                    <a href="{{ route('admin.horarios.edit', $horario->id) }}" class="btn btn-success btn-sm accion-btn">
                                        <i class="fas fa-pencil-alt"></i>
                                    </a>
                                    <form action="{{ route('admin.horarios.destroy', $horario->id) }}" method="POST"
                                        id="formDelete{{ $horario->id }}" onsubmit="return confirmDelete{{ $horario->id }}(event)">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="btn btn-danger btn-sm accion-btn">
                                            <i class="fas fa-trash"></i>
                                        </button>
                                    </form>
                                </div>
                                <script>
                                    function confirmDelete{{ $horario->id }}(event) {
                                        event.preventDefault();
                                        Swal.fire({
                                            title: '¿Desea eliminar este horario?',
                                            icon: 'question',
                                            showDenyButton: true,
                                            confirmButtonText: 'Eliminar',
                                            confirmButtonColor: '#a5161d',
                                            denyButtonText: 'Cancelar',
                                            denyButtonColor: '#270a0a',
                                        }).then((result) => {
                                            if(result.isConfirmed){
                                                document.getElementById('formDelete{{ $horario->id }}').submit();
                                            }
                                        });
                                    }
                                </script>
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
    #horariosTable_wrapper .dt-buttons {
        background-color: transparent;
        box-shadow: none;
        border: none;
        display: flex;
        justify-content: center;
        gap: 10px;
        margin-bottom: 15px;
    }
    #horariosTable_wrapper .btn { color: #fff; border-radius: 4px; padding: 5px 15px; font-size: 14px; }
    .btn-danger { background-color: #dc3545; border: none; }
    .btn-success { background-color: #28a745; border: none; }
    .btn-info { background-color: #17a2b8; border: none; }
    .btn-warning { background-color: #ffc107; color: #212529; border: none; }
    .btn-default { background-color: #6e7176; color: #212529; border: none; }

    /* Botones uniformes en acciones */
    .accion-btn {
        width: 35px;
        height: 35px;
        padding: 0;
        display: flex;
        align-items: center;
        justify-content: center;
    }
</style>
@stop

@section('js')
<script>
    $(function () {
        $("#horariosTable").DataTable({
            scrollX: true,
            "pageLength": 5,
            "language": {
                "emptyTable": "No hay información",
                "info": "Mostrando _START_ a _END_ de _TOTAL_ horarios",
                "infoEmpty": "Mostrando 0 a 0 de 0 horarios",
                "infoFiltered": "(Filtrado de _MAX_ total horarios)",
                "lengthMenu": "Mostrar _MENU_ horarios",
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
        }).buttons().container().appendTo('#horariosTable_wrapper .row:eq(0)');
    });

    @if(session('success'))
    Swal.fire({
        icon: 'success',
        title: '¡Éxito!',
        text: '{{ session('success') }}',
        timer: 2500,
        showConfirmButton: false
    });
    @endif
</script>
@stop

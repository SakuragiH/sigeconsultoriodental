@extends('adminlte::page')

@section('title', 'Pacientes')

@section('content_header')
    <h1><b>Listado de Pacientes</b></h1>
    <hr>
@stop

@section('content')
<div class="row">
    <div class="col-md-12">
        <div class="card card-outline card-primary">
            <div class="card-header">
                <h3 class="card-title">Pacientes registrados</h3>
                <div class="card-tools">
                    <a href="{{ route('admin.pacientes.create') }}" class="btn btn-primary">Crear nuevo</a>
                </div>
            </div>
            <div class="card-body">
                <table id="pacientesTable" class="table table-bordered table-hover table-striped table-sm">
                    <thead>
                        <tr>
                            <th style="text-align: center">Nro</th>
                            <th style="text-align: center">Usuario</th>
                            <th style="text-align: center">Nombres</th>
                            <th style="text-align: center">Apellidos</th>
                            <th style="text-align: center">CI</th>
                            <th style="text-align: center">Fecha Nac.</th>
                            <th style="text-align: center">Teléfono</th>
                            <th style="text-align: center">Dirección</th>
                            <th style="text-align: center">Género</th>
                            <th style="text-align: center">Foto</th>
                            <th style="text-align: center">Acciones</th>
                        </tr>
                    </thead>
                    <tbody>
                        @php $contador = 1; @endphp
                        @foreach($pacientes as $paciente)
                        <tr>
                            <td style="text-align: center">{{ $contador++ }}</td>
                            <td>{{ $paciente->usuario->name ?? '-' }}</td>
                            <td>{{ $paciente->nombres }}</td>
                            <td>{{ $paciente->apellidos }}</td>
                            <td>{{ $paciente->ci }}</td>
                            <td>{{ \Carbon\Carbon::parse($paciente->fecha_nacimiento)->format('d/m/Y') }}</td>
                            <td>{{ $paciente->telefono }}</td>
                            <td>{{ $paciente->direccion }}</td>
                            <td>{{ $paciente->genero }}</td>
                            <td style="text-align: center">
                                @if($paciente->foto)
                                    <img src="{{ asset('storage/pacientes/' . $paciente->foto) }}" 
                                         width="50" height="50" class="rounded-circle" alt="Foto">
                                @else
                                    <span class="text-muted">Sin foto</span>
                                @endif
                            </td>
                            <td style="text-align: center">
                                <div class="btn-group d-flex justify-content-center" role="group">
                                    <a href="{{ route('admin.pacientes.show', $paciente->id) }}" class="btn btn-info btn-sm accion-btn">
                                        <i class="fas fa-eye"></i>
                                    </a>
                                    <a href="{{ route('admin.pacientes.edit', $paciente->id) }}" class="btn btn-success btn-sm accion-btn">
                                        <i class="fas fa-pencil-alt"></i>
                                    </a>
                                    <form action="{{ route('admin.pacientes.destroy', $paciente->id) }}" method="POST"
                                        id="formDelete{{ $paciente->id }}" onsubmit="return confirmDelete{{ $paciente->id }}(event)">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="btn btn-danger btn-sm accion-btn">
                                            <i class="fas fa-trash"></i>
                                        </button>
                                    </form>
                                </div>
                                <script>
                                    function confirmDelete{{ $paciente->id }}(event) {
                                        event.preventDefault();
                                        Swal.fire({
                                            title: '¿Desea eliminar este paciente?',
                                            icon: 'question',
                                            showDenyButton: true,
                                            confirmButtonText: 'Eliminar',
                                            confirmButtonColor: '#a5161d',
                                            denyButtonText: 'Cancelar',
                                            denyButtonColor: '#270a0a',
                                        }).then((result) => {
                                            if(result.isConfirmed){
                                                document.getElementById('formDelete{{ $paciente->id }}').submit();
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
    #pacientesTable_wrapper .dt-buttons {
        background-color: transparent;
        box-shadow: none;
        border: none;
        display: flex;
        justify-content: center;
        gap: 10px;
        margin-bottom: 15px;
    }
    #pacientesTable_wrapper .btn { color: #fff; border-radius: 4px; padding: 5px 15px; font-size: 14px; }
    .btn-danger { background-color: #dc3545; border: none; }
    .btn-success { background-color: #28a745; border: none; }
    .btn-info { background-color: #17a2b8; border: none; }
    .btn-warning { background-color: #ffc107; color: #212529; border: none; }
    .btn-default { background-color: #6e7176; color: #212529; border: none; }

    .accion-btn {
        width: 35px;
        height: 35px;
        padding: 0;
        display: flex;
        align-items: center;
        justify-content: center;
    }

    td img {
        object-fit: cover;
    }
</style>
@stop

@section('js')
<script>
    $(function () {
        $("#pacientesTable").DataTable({
            "pageLength": 5,
            "language": {
                "emptyTable": "No hay información",
                "info": "Mostrando _START_ a _END_ de _TOTAL_ pacientes",
                "infoEmpty": "Mostrando 0 a 0 de 0 pacientes",
                "infoFiltered": "(Filtrado de _MAX_ total pacientes)",
                "lengthMenu": "Mostrar _MENU_ pacientes",
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
        }).buttons().container().appendTo('#pacientesTable_wrapper .row:eq(0)');
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

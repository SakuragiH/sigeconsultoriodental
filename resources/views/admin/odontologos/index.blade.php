@extends('adminlte::page')

@section('title', 'Odontólogos')

@section('content_header')
    <h1><b>Listado de Odontólogos</b></h1>
    <hr>
@stop

@section('content')
<div class="row">
    <div class="col-md-12">
        <div class="card card-outline card-primary">
            <div class="card-header">
                <h3 class="card-title">Odontólogos registrados</h3>
                <div class="card-tools">
                    <a href="{{ route('admin.odontologos.create') }}" class="btn btn-primary">Crear nuevo</a>
                </div>
            </div>
            <div class="card-body">
                <table id="odontologosTable" class="table table-bordered table-hover table-striped table-sm">
                    <thead>
                        <tr>
                            <th style="text-align: center">Nro</th>
                            <th style="text-align: center">Rol</th>
                            <th style="text-align: center">Nombres</th>
                            <th style="text-align: center">Apellidos</th>
                            <th style="text-align: center">Email</th>
                            <th style="text-align: center">Formación</th>
                            <th style="text-align: center">Especialidad</th>
                            <th style="text-align: center">Teléfono</th>
                            <th style="text-align: center">Estado</th>
                            <th style="text-align: center">Foto</th>
                            <th style="text-align: center">Acciones</th>
                        </tr>
                    </thead>
                    <tbody>
                        @php $contador = 1; @endphp
                        @foreach($odontologos as $odontologo)
                        <tr>
                            <td style="text-align: center">{{ $contador++ }}</td>
                            <td>{{ $odontologo->usuario->roles->pluck('name')->implode(', ') }}</td>
                            <td>{{ $odontologo->nombres }}</td>
                            <td>{{ $odontologo->apellidos }}</td>
                            <td>{{ $odontologo->usuario->email ?? '-' }}</td>
                            <td>{{ $odontologo->formacion ?? '-' }}</td>
                            <td>{{ $odontologo->especialidad ?? '-' }}</td>
                            <td>{{ $odontologo->telefono ?? '-' }}</td>
                            <td>
                                <span class="badge {{ $odontologo->estado == 'activo' ? 'bg-success' : 'bg-danger' }}">
                                    {{ ucfirst($odontologo->estado) }}
                                </span>
                            </td>
                            <td style="text-align: center">
                                @if($odontologo->foto)
                                    <img src="{{ url($odontologo->foto) }}" width="50" height="50" class="rounded-circle" alt="Foto">
                                @else
                                    <span class="text-muted">Sin foto</span>
                                @endif
                            </td>
                            <td style="text-align: center">
                                <div class="btn-group d-flex justify-content-center" role="group">
                                    <a href="{{ route('admin.odontologos.show', $odontologo->id) }}" class="btn btn-info btn-sm accion-btn">
                                        <i class="fas fa-eye"></i>
                                    </a>
                                    <a href="{{ route('admin.odontologos.edit', $odontologo->id) }}" class="btn btn-success btn-sm accion-btn">
                                        <i class="fas fa-pencil-alt"></i>
                                    </a>
                                    <form action="{{ route('admin.odontologos.destroy', $odontologo->id) }}" method="POST"
                                        id="formDelete{{ $odontologo->id }}" onsubmit="return confirmDelete{{ $odontologo->id }}(event)">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="btn btn-danger btn-sm accion-btn">
                                            <i class="fas fa-trash"></i>
                                        </button>
                                    </form>
                                </div>
                                <script>
                                    function confirmDelete{{ $odontologo->id }}(event) {
                                        event.preventDefault();
                                        Swal.fire({
                                            title: '¿Desea eliminar este odontólogo?',
                                            icon: 'question',
                                            showDenyButton: true,
                                            confirmButtonText: 'Eliminar',
                                            confirmButtonColor: '#a5161d',
                                            denyButtonText: 'Cancelar',
                                            denyButtonColor: '#270a0a',
                                        }).then((result) => {
                                            if(result.isConfirmed){
                                                document.getElementById('formDelete{{ $odontologo->id }}').submit();
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
    #odontologosTable_wrapper .dt-buttons {
        background-color: transparent;
        box-shadow: none;
        border: none;
        display: flex;
        justify-content: center;
        gap: 10px;
        margin-bottom: 15px;
    }
    #odontologosTable_wrapper .btn { color: #fff; border-radius: 4px; padding: 5px 15px; font-size: 14px; }
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

    /* Ajuste de imágenes */
    td img {
        object-fit: cover;
    }
</style>
@stop

@section('js')
<script>
    $(function () {
        $("#odontologosTable").DataTable({
            "pageLength": 5,
            "language": {
                "emptyTable": "No hay información",
                "info": "Mostrando _START_ a _END_ de _TOTAL_ odontólogos",
                "infoEmpty": "Mostrando 0 a 0 de 0 odontólogos",
                "infoFiltered": "(Filtrado de _MAX_ total odontólogos)",
                "lengthMenu": "Mostrar _MENU_ odontólogos",
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
        }).buttons().container().appendTo('#odontologosTable_wrapper .row:eq(0)');
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




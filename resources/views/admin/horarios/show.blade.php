@extends('adminlte::page')

@section('content_header')
    <h1><b>Horarios / Detalles del horario</b></h1>
    <hr>
@stop

@section('content')
<div class="row">
    <div class="col-md-12">
        <div class="card card-primary">
            <div class="card-header">
                <h3 class="card-title">Información detallada del horario</h3>
            </div>
            <div class="card-body">
                <table class="table table-bordered table-striped">
                    <tbody>
                        <tr>
                            <th>Odontólogo</th>
                            <td>{{ $horario->odontologo->nombres }} {{ $horario->odontologo->apellidos }}</td>
                        </tr>
                        <tr>
                            <th>Día</th>
                            <td>{{ $horario->dia }}</td>
                        </tr>
                        <tr>
                            <th>Hora inicio</th>
                            <td>{{ \Carbon\Carbon::parse($horario->hora_inicio)->format('H:i') }}</td>
                        </tr>
                        <tr>
                            <th>Hora fin</th>
                            <td>{{ \Carbon\Carbon::parse($horario->hora_fin)->format('H:i') }}</td>
                        </tr>
                        <tr>
                            <th>Estado</th>
                            <td>
                                @if($horario->disponible)
                                    <span class="badge badge-success">Disponible</span>
                                @else
                                    <span class="badge badge-danger">Bloqueado</span>
                                @endif
                            </td>
                        </tr>
                        <tr>
                            <th>Creado</th>
                            <td>{{ $horario->created_at->format('d/m/Y H:i') }}</td>
                        </tr>
                        <tr>
                            <th>Actualizado</th>
                            <td>{{ $horario->updated_at->format('d/m/Y H:i') }}</td>
                        </tr>
                    </tbody>
                </table>
                <div class="mt-3">
                    <a href="{{ route('admin.horarios.index') }}" class="btn btn-secondary">Volver</a>
                </div>
            </div>
        </div>
    </div>
</div>
@stop

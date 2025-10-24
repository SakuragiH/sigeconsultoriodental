@extends('adminlte::page')

@section('title', 'Detalle del Paciente')

@section('content_header')
    <h1><b>Detalle del Paciente</b></h1>
    <hr>
@stop

@section('content')
<div class="row">
    <div class="col-md-12">
        <div class="card card-info">
            <div class="card-header">
                <h3 class="card-title">Datos registrados</h3>
            </div>
            <div class="card-body">
                <div class="row">
                    <!-- NOMBRES -->
                    <div class="col-md-3">
                        <div class="form-group">
                            <label for="nombres">Nombres</label>
                            <input type="text" class="form-control" value="{{ $paciente->nombres }}" disabled>
                        </div>
                    </div>

                    <!-- APELLIDOS -->
                    <div class="col-md-3">
                        <div class="form-group">
                            <label for="apellidos">Apellidos</label>
                            <input type="text" class="form-control" value="{{ $paciente->apellidos }}" disabled>
                        </div>
                    </div>

                    <!-- EMAIL -->
                    <div class="col-md-3">
                        <div class="form-group">
                            <label for="email">Email</label>
                            <input type="email" class="form-control" value="{{ $paciente->usuario->email ?? '-' }}" disabled>
                        </div>
                    </div>

                    <!-- TELEFONO -->
                    <div class="col-md-3">
                        <div class="form-group">
                            <label for="telefono">Teléfono</label>
                            <input type="text" class="form-control" value="{{ $paciente->telefono ?? '-' }}" disabled>
                        </div>
                    </div>
                </div>

                <div class="row">
                    <!-- CI -->
                    <div class="col-md-3">
                        <div class="form-group">
                            <label for="ci">CI</label>
                            <input type="text" class="form-control" value="{{ $paciente->ci ?? '-' }}" disabled>
                        </div>
                    </div>

                    <!-- FECHA NACIMIENTO -->
                    <div class="col-md-3">
                        <div class="form-group">
                            <label for="fecha_nacimiento">Fecha de nacimiento</label>
                            <input type="date" class="form-control" value="{{ $paciente->fecha_nacimiento ?? '-' }}" disabled>
                        </div>
                    </div>

                    <!-- GENERO -->
                    <div class="col-md-3">
                        <div class="form-group">
                            <label for="genero">Género</label>
                            <input type="text" class="form-control" value="{{ $paciente->genero ?? '-' }}" disabled>
                        </div>
                    </div>

                    <!-- FOTO -->
                    <div class="col-md-3">
                        <div class="form-group">
                            <label for="foto">Foto</label>
                            <div>
                                @if($paciente->foto)
                                    <img src="{{ url($paciente->foto) }}" alt="Foto Paciente" class="img-thumbnail">
                                @else
                                    <img src="{{ url('uploads/fotos_pacientes/default.png') }}" alt="Sin foto" class="img-thumbnail">
                                @endif
                            </div>
                        </div>
                    </div>
                </div>

                <!-- DIRECCION -->
                <div class="row">
                    <div class="col-md-12">
                        <div class="form-group">
                            <label for="direccion">Dirección</label>
                            <input type="text" class="form-control" value="{{ $paciente->direccion ?? '-' }}" disabled>
                        </div>
                    </div>
                </div>

                <hr>

                <div class="row">
                    <div class="col-md-12">
                        <a href="{{ route('admin.pacientes.index') }}" class="btn btn-secondary">Volver</a>
                    </div>
                </div>

            </div>
        </div>
    </div>
</div>
@stop

@section('css')
<style>
    .img-thumbnail {
        object-fit: cover;
        height: 120px;
        width: 120px;
    }
</style>
@stop

@section('js')
@stop


